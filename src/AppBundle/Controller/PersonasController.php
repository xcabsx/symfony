<?php

namespace AppBundle\Controller;

use BackendBundle\Entity\DireccionesXPersonas;
use BackendBundle\Entity\Personas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Component\HttpFoundation\Request;

class PersonasController extends Controller
{


    public function personasAction(Request $request){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);

        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        $tp = $request->get('tp');
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            $em = $this->getDoctrine()->getManager();
            $dql = '';
            if(isset($tp)){
                $dql = "SELECT t FROM BackendBundle:Personas t where t.tipoPersona = $tp";
            }else{
                $dql = "SELECT t FROM BackendBundle:Personas t ";
            }

            $query = $em->createQuery($dql);


            $page = $request->query->getInt('page',1);
            $paginator = $this->get('knp_paginator');
            $items_per_page = 10;

            $pagination = $paginator->paginate($query,$page,$items_per_page);

            $total_items_count = $pagination->getTotalItemCount();

            $data= array(
                "status"=>"success",
                "code"=>200,
                "total_items_count"=>$total_items_count,
                "page_actual"=> $page,
                "items_per_page"=> $items_per_page,
                "total_pages"=> ceil($total_items_count / $items_per_page),
                "data"=>$pagination

            );

        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }

    public function newAction(Request $request){
        $helpers = $this->get(Helpers::class);

        $json = $request->get("json",null);
        $params = json_decode($json);

        $data = array(
            'status'=> 'error' ,
            'code'=> 400,
            'msg'=>'User not created'
        );

        if( $json != null){

            $createdAt = new \DateTime("now");
            $dni = (isset($params->dni)) ?$params->dni : null;
            $nombre = (isset($params->nombre)) ?$params->nombre : null;
            $apellido = (isset($params->apellido)) ?$params->apellido : null;
            $cuit = (isset($params->cuit)) ?$params->cuit : null;
            $fecha_nac = (isset($params->fecha_nac)) ?$params->fecha_nac : null; // 01/01/1986
            $tipoPersona = (isset($params->tipop)) ?$params->tipop : null;
            $estado = 'Activo';

            $literalTime    =   \DateTime::createFromFormat("d/m/Y",$fecha_nac);
            $fecha_nac_formateada =  $literalTime->format("d-m-y");
            //var_dump($fecha_nac_formateada);




            if($dni != null && $nombre != null && $apellido != null && $tipoPersona != null ){

                /** @var Personas usuario a grabar o modificar  */
                $persona = new Personas();
                $persona->setDni($dni);
                $persona->setNombre($nombre);
                $persona->setApellido($apellido);
                $persona->setCuilCuit($cuit);
                $persona->setFechaNacimiento($literalTime); // objeto fecha
                $persona->setEstado($estado);
                $persona->setFechaAlta($createdAt);

                /** @var EntityManager Entity manager de doctrine */
                $em = $this->getDoctrine()->getManager();
                /** @var Roles Traigo el tipo persona */
                $OBJtipoPersona = $em->getRepository('BackendBundle:TiposPersonas')->findOneBy(array(
                    "id"=>$tipoPersona
                ));

                $persona->setTipoPersona($OBJtipoPersona);

                /** @var Users Comprueba si hay algun usuario en la base con ese dni */
                $isset_user = $em->getRepository('BackendBundle:Personas')->findBy(array(
                    "dni"=>$dni
                ));

                if(count($isset_user) == 0){

                    $em->persist($persona);
                    $em->flush();

                    $data = array(
                        'status'=> 'success' ,
                        'code'=> 200,
                        'msg'=>'User created',
                        'user'=>$persona
                    );

                }else{
                    $data = array(
                        'status'=> 'error' ,
                        'code'=> 400,
                        'msg'=>'User duplicated'
                    );

                }



            }
        }

        return $helpers->json($data);
    }


    /**
     * funciones de direccion.
     *
     */

    public function DireccionesxPersonaAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);
        $tieneAcceso = false;






        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            foreach ($identity->Permisos as $pepe){
                if($pepe === 'Administrador'){
                    $tieneAcceso = true;
                }
            }

            if( $tieneAcceso) {


                $em = $this->getDoctrine()->getManager();
                $direccionesxPersona = $em->getRepository('BackendBundle:DireccionesXPersonas')->findBy(array(
                    "idPersona" => $id
                ));

                $Personas = $em->getRepository('BackendBundle:Personas')->findBy(array(
                    'estado' => 'Activo'
                ));

                $PersonaActiva = $em->getRepository('BackendBundle:Personas')->findOneBy(array(
                    "id" => $id
                ));
                $descripcionRol = $PersonaActiva->getNombre().' '.$PersonaActiva->getApellido();
                $estadoRol = $PersonaActiva->getEstado();


                if ($direccionesxPersona) {
                    foreach ($direccionesxPersona as $iperpepe) {

                      if ($iperpepe->getEstado() === 'Activo' && $PersonaActiva->getEstado() === 'Activo') {


                          $arrayDireccion['calle'] = $iperpepe->getCalle();
                          $arrayDireccion['numero'] = $iperpepe->getNumero();
                          $arrayDireccion['provincia'] = $iperpepe->getProvincia();
                          $arrayDireccion['pais'] = $iperpepe->getPais();
                          $arrayDireccion['estado'] = $iperpepe->getEstado();

                          $direcciones[] = $arrayDireccion;


                            $data = array(
                                "status" => "success",
                                "code" => 200,
                                "data" => $direcciones,
                                "persona" => $PersonaActiva

                            );
                        } else {
                            if (isset($direcciones)) {

                            } else {
                                $direcciones = null;
                            }

                            $data = array(
                                "status" => "success",
                                "code" => 200,
                                "data" => $direcciones,
                                "persona" => $PersonaActiva
                            );

                        }
                    }
                    //$json = $json."]";
                } else {
                    $data = array(
                        "status" => "success",
                        "code" => 200,
                        "data" => null,
                        "persona" => $PersonaActiva


                    );
                }


                //  echo json_encode($catList);

                // $permJson = $helpers->json($json);
                // echo json_encode($json);


            }else{
                //no es admin
                $data= array(
                    "status"=>"Error",
                    "code"=>301,
                    "message"=>"No tiene privilegios para usar esta funcion!"

                );
            }
        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }

    public function NewDireccionesxPersonaAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        $json = $request->get('json',null);
        $params = json_decode($json);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);
        $tieneAcceso = false;






        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            foreach ($identity->Permisos as $pepe){
                if($pepe === 'Administrador'){
                    $tieneAcceso = true;
                }
            }

            if( $tieneAcceso) {


                $em = $this->getDoctrine()->getManager();

                $PersonaActiva = $em->getRepository('BackendBundle:Personas')->findOneBy(array(
                    "id" => $id
                ));
                $descripcionRol = $PersonaActiva->getNombre().' '.$PersonaActiva->getApellido();
                $estadoRol = $PersonaActiva->getEstado();

                $data = array(
                    'status'=> 'error' ,
                    'code'=> 400,
                    'msg'=>'direccion no creada',
                    'direccion'=>null
                );



                if($json != null){

                   $createdAt = new \DateTime("now");
                   $pais = (isset($params->pais))?$params->pais: null;
                   $provincia = (isset($params->prov))?$params->prov: null;
                   $localidad = (isset($params->loc))?$params->loc: null;
                    $calle = (isset($params->calle))?$params->calle : null;
                    $numero = (isset($params->nro))?$params->nro : null;
                    $casa = (isset($params->casa))?$params->casa: null;
                    $piso = (isset($params->piso))?$params->piso: null;
                    $depto = (isset($params->depto))?$params->depto: null;
                    $manzana = (isset($params->manz))?$params->manz: null;

                    $estado = 'Activo';

                    if($calle != null && $numero != null && $localidad != null){

                        $direcciones = new DireccionesXPersonas();
                        $direcciones->setEstado($estado);
                        $direcciones->setIdPersona($PersonaActiva);
                        $direcciones->setPais($pais);
                        $direcciones->setProvincia($provincia);
                        $direcciones->setLocalidad($localidad);
                        $direcciones->setCalle($calle);
                        $direcciones->setNumero($numero);
                        $direcciones->setCasa($casa);
                        $direcciones->setPiso($piso);
                        $direcciones->setDpto($depto);
                        $direcciones->setManzana($manzana);
                        $direcciones->setFechaAlta($createdAt);

                        $em->persist($direcciones);
                        $em->flush();

                        $data = array(
                            'status'=> 'success' ,
                            'code'=> 200,
                            'msg'=>'direccion creada',
                            'direccion'=>$direcciones
                        );




                    }




                }


            }else{
                //no es admin
                $data= array(
                    "status"=>"Error",
                    "code"=>301,
                    "message"=>"No tiene privilegios para usar esta funcion!"

                );
            }
        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }




}
