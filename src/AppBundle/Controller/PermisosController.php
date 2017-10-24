<?php

namespace AppBundle\Controller;

use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use BackendBundle\Entity\Permisos;
use BackendBundle\Entity\PermisosXRol;
use BackendBundle\Entity\Roles;
use BackendBundle\Entity\RolesXUser;
use BackendBundle\Entity\RolPermisoAplicacion;
use BackendBundle\Entity\RolXUsuarioXAplicacion;
use BackendBundle\Entity\User;
use Doctrine\DBAL\Types\JsonArrayType;
use Doctrine\DBAL\Types\ObjectType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Tests\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class PermisosController
 * @package AppBundle\Controller
 */
class PermisosController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @param Request $request
     */
    public function pruebasAction(Request $request)
    {
        echo "hola mundo con sinfoni3 <hr />";
        die();
    }

    /**
     * Metodo para dar de alta nuevo permiso.
     * @param Request $request
     * @param null $id Opcional, si es null = Alta si, no es Edicion.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPAction(Request $request, $id = null){


        /**
         * @var Service para convertir Objetos a JSON
         */
        $helpers = $this->get(Helpers::class);


        /** @var JwtAuth Servicio para Login y Control de acceso */
        $jwt_auth = $this->get(JwtAuth::class);


        /** @var string Recupera token de peticion http  */
        $token = $request->get('authorization',null);

        /** @var boolean Resultado de Chequeo validez del token
         * @return boolean
         */
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){

            /** @var ObjectType Recupera datos decriptados del token*/
            $identity = $jwt_auth->checkToken($token,true);


            /** @var string Recibe Datos del cuerpo de la peticion. */
            $json = $request->get('json',null);

            if($json != null){

                /** @var Object convierte el parametro en un objeto.*/
                $params = json_decode($json);


                /** @var DateTime  fecha de creacion */
                $createdAt = new \Datetime('now');
                /** @var DateTime fecha de Modificacion */
                $updatedAt = new \Datetime('now');

                /**
                 * @var string ID del usuario Logeado
                */
                $userId = ($identity->sub!=null)? $identity->sub: null;
                $useremail = ($identity->email);
                /** @var array Array de persimos de usuario */
                $userPermisos = $identity->Permisos;


                /**
                 * True si tiene acceso False si no @var boolean
                 * Solo tendra acceso si tiene un permiso de Administrador
                */
                $tieneAcceso = false;


                foreach ($userPermisos as $iValue) {
                    if($iValue === "Administrador"){
                        $tieneAcceso = true;
                    }
                }


                /** @var string Descripcion del Permiso a dar de alta o modificar */
                $description = (isset($params->description)) ? $params->description: null;

                /**
                 * Si tiene acceso se ejecuta el Alta o Modificacion.
                 * sino regresa un error.
                 */
    if($tieneAcceso){

        /**
         * Si existe $userId y $description continua
         * sino Error
         */
                if($userId != null && $description != null){

                    /** @var EntityManager Instancia el entity manager */
                    $em = $this->getDoctrine()->getManager();

                    /**
                     * Si @var $id == null Da de alta un nuevo permiso.
                     * sino es una modicifacion.
                     */
                    if($id == null){

                        /** @var Permisos Crea nueva variable Para dar de Alta,
                         * agrega la descripcion al objeto.
                         * graba el objeto
                         */

                        $permiso = new Permisos();
                        $permiso->setDescripPermiso($description);
                        $permiso->setCreado($createdAt);
                        $permiso->setUsuario($identity->sub);
                        $permiso->setEstado('Activo');

                        $em->persist($permiso);
                        $em->flush();

                        /** @var array Salida de la Api.
                         *code 200 cuando es correcta
                         *otros codigos depende los errores.
                         */
                        $data= array(
                            "status"=>"success",
                            "code"=>200,
                            "data"=>$permiso
                        );
                    }else{

                        $permiso = $em->getRepository('BackendBundle:Permisos')->findOneBy(array(
                            "idPermiso"=> $id
                        ));

                            $permiso->setDescripPermiso($description);

                            $em->persist($permiso);
                            $em->flush();

                            $data= array(
                                "status"=>"success updated",
                                "code"=>200,
                                "data"=>$permiso
                            );
                    }


                }else{
                    $data= array(
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"permiso no creado,validation failed"
                    );

                };
    }else{
        $data= array(
            "status"=>"denegado",
            "code"=>200,
            "message"=>"no tiene privilegios suficientes para realizar la operacion."
        );

    }


            }else{

                $data= array(
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"tarea no creada, error de parametro"
                );


            }



        }else{

            $data= array(
                "status"=>"error",
                "code"=>400,
                "message"=>"autorization not valid"
            );

        }

        return $helpers->json($data);
    }

    /**
     * Metodo para dar de alta nuevo Rol.
     * @param Request $request
     * @param null $id Opcional, si es null = Alta si, no es Edicion.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newRAction(Request $request, $id = null){


        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);

        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);
            //traigo los datos de la nueva tarea del post
            $json = $request->get('json',null);

            if($json != null){
                //convierto a json los parametros del post
                $params = json_decode($json);

                //creacion de variables
                $createdAt = new \Datetime('now');
                $updatedAt = new \Datetime('now');

                $userId = ($identity->sub!=null)? $identity->sub: null;

                $description = (isset($params->description)) ? $params->description: null;



                if($userId != null && $description != null){
                    //instancia entity manager!!.
                    $em = $this->getDoctrine()->getManager();

                    //busca en la tabla de usuarios por ID.


                    if($id == null){

                        $rol = new Roles();
                        $rol->setDescRol($description);
                        $rol->setCreado($createdAt);
                        $rol->setEstado('Activo');
                        $rol->setUsuario($identity->sub);

                        $em->persist($rol);
                        $em->flush();

                        $data= array(
                            "status"=>"success",
                            "code"=>200,
                            "data"=>$rol
                        );
                    }else{


                        $rol = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                            "rolId"=> $id
                        ));

                        $rol->setDescRol($description);

                        $em->persist($rol);
                        $em->flush();

                        $data= array(
                            "status"=>"success updated",
                            "code"=>200,
                            "data"=>$rol
                        );
                    }


                }else{
                    $data= array(
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"permiso no creado,validation failed"
                    );

                };


            }else{

                $data= array(
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"permiso no creado, error de parametro"
                );


            }

            /*$data= array(
                "status"=>"success",
                "code"=>200,
                "message"=>"ok"
                );*/


        }else{

            $data= array(
                "status"=>"error",
                "code"=>400,
                "message"=>"autorization not valid"
            );

        }

        return $helpers->json($data);
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPxRAction(Request $request, $id = null){


        /**
         * @var Service para convertir Objetos a JSON
         */
        $helpers = $this->get(Helpers::class);


        /** @var JwtAuth Servicio para Login y Control de acceso */
        $jwt_auth = $this->get(JwtAuth::class);


        /** @var string Recupera token de peticion http  */
        $token = $request->get('authorization',null);

        /** @var boolean Resultado de Chequeo validez del token
         * @return boolean
         */
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){

            /** @var ObjectType Recupera datos decriptados del token*/
            $identity = $jwt_auth->checkToken($token,true);


            /** @var string Recibe Datos del cuerpo de la peticion. */
            $json = $request->get('json',null);


            if($json != null){

                /** @var Object convierte el parametro en un objeto.*/
                $params = json_decode($json);



                /** @var DateTime  fecha de creacion */
                $createdAt = new \Datetime('now');
                /** @var DateTime fecha de Modificacion */
                $updatedAt = new \Datetime('now');

                /**
                 * @var string ID del usuario Logeado
                 */
                $userId = ($identity->sub!=null)? $identity->sub: null;
                $useremail = ($identity->email);
                /** @var array Array de persimos de usuario */
                $userPermisos = $identity->Permisos;


                /**
                 * True si tiene acceso False si no @var boolean
                 */
                $tieneAcceso = false;


                foreach ($userPermisos as $iValue) {
                    if($iValue === "Administrador"){
                        $tieneAcceso = true;
                    }
                }


                /** @var string Parametro id de permiso */
                $paramPermisoId = (isset($params->permid)) ? $params->permid: null;
                /** @var string Parametro id de Rol */
                $paramRolId = (isset($params->rolid)) ? $params->rolid: null;

                //$aplicaionId = (isset($params->aplid)) ? $params->aplid: null;

                /**
                 * Si tiene acceso se ejecuta el Alta o Modificacion.
                 * sino regresa un error.
                 */
                if($tieneAcceso){

                    /**
                     * Si existe $userId y $description continua
                     * sino Error
                     */

                    if($userId != null && $paramPermisoId != null && $paramRolId ){

                        // @todo buscar repetidos.

                        /** @var EntityManager Instancia el entity manager */
                        $em = $this->getDoctrine()->getManager();

                        $permisos = $em->getRepository('BackendBundle:Permisos')->findOneBy(array(
                            "idPermiso"=> $paramPermisoId
                        ));
                        $roles = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                            "rolId"=> $paramRolId
                        ));
                        $permisosXrol = new PermisosXRol();

                       // $rolXpermisoXapl = new RolPermisoAplicacion();


                        /**
                         * Si @var $id == null Da de alta un nuevo permiso.
                         * sino es una modicifacion.
                         */
                        if($id == null){
                            /** @var permisosXrol Crea nueva variable Para dar de Alta,
                             * agrega los IDs al objeto.
                             * graba el objeto
                             */

                           $permisosXrol->setIdPermiso($permisos);
                           $permisosXrol->setIdRol($roles);

                            /*$rolXpermisoXapl->setIdaplicacion($aplicacion);
                            $rolXpermisoXapl->setIdpermiso($permisos);
                            $rolXpermisoXapl->setIdrol($roles);
                            $rolXpermisoXapl->setFechaCreacion($createdAt);*/

                            /** @var string Controla que los datos pasados esteen marcados como activos @todo Controlar que los 3 tengan estado activo, sino rcar con KO */
                            $activo= 'OK';

                            if($activo === 'OK') {
                                $em->persist($permisosXrol);
                                $em->flush();

                                $data= array(
                                    "status"=>"success",
                                    "code"=>200,
                                    "data"=>$permisosXrol
                                );
                            }else{
                                $data= array(
                                    "status"=>"Error",
                                    "code"=>200,
                                    "msg"=>'Permisos , roles inactivas. no se puede dar de alta'
                                );

                            }

                            /** @var array Salida de la Api.
                             *code 200 cuando es correcta
                             *otros codigos depende los errores.
                             */

                        }else{

                            $permisosXrol = $em->getRepository('BackendBundle:PermisosXRol')->findOneBy(array(
                                "id"=> $id
                            ));

                            $permisosXrol->setIdRol($roles);
                            $permisosXrol->setIdPermiso($permisos);

                            $em->persist($permisosXrol);
                            $em->flush();

                            $data= array(
                                "status"=>"success updated",
                                "code"=>200,
                                "data"=>$permisosXrol
                            );
                        }


                    }else{
                        $data= array(
                            "status"=>"error",
                            "code"=>400,
                            "message"=>"permiso no creado,validation failed"
                        );

                    };
                }else{
                    $data= array(
                        "status"=>"denegado",
                        "code"=>200,
                        "message"=>"no tiene privilegios suficientes para realizar la operacion."
                    );

                }


            }else{

                $data= array(
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"permiso no creado, error de parametro"
                );


            }



        }else{

            $data= array(
                "status"=>"error",
                "code"=>400,
                "message"=>"autorization not valid"
            );

        }

        return $helpers->json($data);
    }

    /**
     * Funcion para dar de alta o modificar los roles por Usuarios
     * @param Request $request La peticion con los parametros
     * @param null $id Parametro Opcional , si existe el ID es una modificacion.
     * @return $data {
            "status"=>"status",
            "code"=> code,
            "msg / Objeto"=>"msg/objeto"'}
     */
    public function newRxUxAAction(Request $request, $id = null){


        /**
         * @var Service para convertir Objetos a JSON
         */
        $helpers = $this->get(Helpers::class);


        /** @var JwtAuth Servicio para Login y Control de acceso */
        $jwt_auth = $this->get(JwtAuth::class);


        /** @var string Recupera token de peticion http  */
        $token = $request->get('authorization',null);

        /** @var boolean Resultado de Chequeo validez del token
         * @return boolean
         */
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){

            /** @var ObjectType Recupera datos decriptados del token*/
            $identity = $jwt_auth->checkToken($token,true);


            /** @var string Recibe Datos del cuerpo de la peticion. */
            $json = $request->get('json',null);


            if($json != null){

                /** @var Object convierte el parametro en un objeto.*/
                $params = json_decode($json);



                /** @var DateTime  fecha de creacion */
                $createdAt = new \Datetime('now');
                /** @var DateTime fecha de Modificacion */
                $updatedAt = new \Datetime('now');

                /**
                 * @var string ID del usuario Logeado
                 */
                $userId = ($identity->sub!=null)? $identity->sub: null;
                $useremail = ($identity->email);
                /** @var array Array de persimos de usuario */
                $userPermisos = $identity->Permisos;


                /**
                 * True si tiene acceso False si no @var boolean
                 */
                $tieneAcceso = false;


                foreach ($userPermisos as $iValue) {
                    if($iValue === "Administrador"){
                        $tieneAcceso = true;
                    }
                }


                /** @var string Parametro id de permiso */
                $paramUserId = (isset($params->userid)) ? $params->userid: null;
                /** @var string Parametro id de Rol */
                $paramRolId = (isset($params->rolid)) ? $params->rolid: null;


                /**
                 * Si tiene acceso se ejecuta el Alta o Modificacion.
                 * sino regresa un error.
                 */
                if($tieneAcceso){

                    /**
                     * Si existe $paramRolId y $paramUserId y $aplicationId  continua
                     * sino Error
                     */

                    if($userId != null && $paramUserId != null && $paramRolId ){



                        /** @var EntityManager Instancia el entity manager */
                        $em = $this->getDoctrine()->getManager();

                        $usuarios = $em->getRepository('BackendBundle:Users')->findOneBy(array(
                            "id"=> $paramUserId
                        ));
                        $roles = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                            "rolId"=> $paramRolId
                        ));


                        /** @var RolXUsuarioXAplicacion instancia el objeto a dar de alta o modificar */
                        $rolXusuario = new RolesXUser();


                        /**
                         * Si @var $id == null Da de alta un nuevo permiso.
                         * sino es una modicifacion.
                         */
                        if($id == null){
                            /** @var permisosXrol Crea nueva variable Para dar de Alta,
                             * agrega los IDs al objeto.
                             * graba el objeto
                             */

                            $rolXusuario->setUserid($usuarios);
                            $rolXusuario->setRolid($roles);


                            /** @var string Controla que los datos pasados esteen marcados como activos @todo Controlar que los 3 tengan estado activo, sino rcar con KO */
                            $activo= 'OK';

                            if($activo === 'OK') {
                                $em->persist($rolXusuario);
                                $em->flush();

                                $data= array(
                                    "status"=>"success",
                                    "code"=>200,
                                    "data"=>$rolXusuario
                                );
                            }else{
                                $data= array(
                                    "status"=>"Error",
                                    "code"=>200,
                                    "msg"=>'Permisos , roles o aplicaciones inactivas. no se puede dar de alta'
                                );

                            }

                            /** @var array Salida de la Api.
                             *code 200 cuando es correcta
                             *otros codigos depende los errores.
                             */

                        }else{
                            /*@todo arreglar para editar lo correcto*/
                            $rolXusuario = $em->getRepository('BackendBundle:RolesXUser')->findOneBy(array(
                                "id"=> $id
                            ));

                            $rolXusuario->setIdRol($roles);
                            $rolXusuario->setUserid($usuarios);

                            $em->persist($rolXusuario);
                            $em->flush();

                            $data= array(
                                "status"=>"success updated",
                                "code"=>200,
                                "data"=>$rolXusuario
                            );
                        }


                    }else{
                        $data= array(
                            "status"=>"error",
                            "code"=>400,
                            "message"=>"permiso no creado,validation failed"
                        );

                    };
                }else{
                    $data= array(
                        "status"=>"denegado",
                        "code"=>200,
                        "message"=>"no tiene privilegios suficientes para realizar la operacion."
                    );

                }


            }else{

                $data= array(
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"tarea no creada, error de parametro"
                );


            }



        }else{

            $data= array(
                "status"=>"error",
                "code"=>400,
                "message"=>"autorization not valid"
            );

        }

        return $helpers->json($data);
    }

    public function editAction(){
    }
    public function rolesAction(Request $request){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);

        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            $em = $this->getDoctrine()->getManager();

            $dql = 'SELECT t FROM BackendBundle:Roles t ';
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
    public function PerxRolAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            $em = $this->getDoctrine()->getManager();
            $PpermisosxRol = $em->getRepository('BackendBundle:PermisosXRol')->findBy(array(
                "idRol"=>$id
            ));
            $rolActivo = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                "rolId"=>$id
            ));

            $rolDescripcion = $rolActivo->getDescRol();

            if($PpermisosxRol){
            foreach ($PpermisosxRol as $iper) {
                $idPer =  (string)$iper->getIdPermiso()->getIdPermiso();
                $descPer = (string)$iper->getIdPermiso()->getDescripPermiso();
                $estadoPer = (string)$iper->getIdPermiso()->getEstado();


                $descPer = print_r($descPer,true);
                $idPer = print_r($idPer,true);

                $arrayname['id'] = $idPer;
                $arrayname['permiso'] = $descPer;
                $arrayname['estado']=$estadoPer;

                $catList[] = $arrayname;


                $permisos[] = $iper->getIdPermiso()->getDescripPermiso() ;

                $data= array(
                    "status"=>"success",
                    "code"=>200,
                    "data"=>$catList,
                    "Rol"=>$rolDescripcion

                );
            }
                //$json = $json."]";
            }else{
                $data= array(
                    "status"=>"success",
                    "code"=>200,
                    "data"=>null,
                    "Rol"=>$rolDescripcion

                );
            }



          //  echo json_encode($catList);

           // $permJson = $helpers->json($json);
           // echo json_encode($json);



        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }
    public function RolxUserAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            $em = $this->getDoctrine()->getManager();
            $rolxUser = $em->getRepository('BackendBundle:RolesXUser')->findBy(array(
                "userid"=>$id
            ));
            $userActivo = $em->getRepository('BackendBundle:Users')->findOneBy(array(
                "id"=>$id
            ));

            $userDescripcion = $userActivo->getName() .' '.$userActivo->getSurname();

            if($rolxUser){
                foreach ($rolxUser as $iper) {
                    $idRol =  (string)$iper->getRolid()->getRolId();
                    $descRol = (string)$iper->getRolid()->getDescRol();
                    $estadoRol = (string)$iper->getRolid()->getEstado();


                    $descRol = print_r($descRol,true);
                    $idRol = print_r($idRol,true);

                    $arrayname['rolId'] = $idRol;
                    $arrayname['descRol'] = $descRol;
                    $arrayname['estado']=$estadoRol;

                    $catList[] = $arrayname;


                    $data= array(
                        "status"=>"success",
                        "code"=>200,
                        "data"=>$catList,


                    );
                }
                //$json = $json."]";
            }else{
                $data= array(
                    "status"=>"success",
                    "code"=>200,
                    "data"=>null,


                );
            }



            //  echo json_encode($catList);

            // $permJson = $helpers->json($json);
            // echo json_encode($json);



        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }
    public function UserxRolAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);

            $em = $this->getDoctrine()->getManager();
            $rolxUser = $em->getRepository('BackendBundle:RolesXUser')->findBy(array(
                "rolid"=>$id
            ));

            $Users = $em->getRepository('BackendBundle:Users')->findall();

            $rolActivo = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                "rolId"=>$id
            ));
            $descripcionRol = $rolActivo->getDescRol();



            if($rolxUser){
                foreach ($rolxUser as $iper) {

                    $idUser = (string)$iper->getUserid()->getId();
                    $idUserName = (string)$iper->getUserid()->getName();
                    $idUserSurName = (string)$iper->getUserid()->getSurname();
                    $idUserEmail = (string)$iper->getUserid()->getEmail();

                    foreach ($Users as $iper2) {
                        $idUsuario = $iper2->getId();
                        if ($idUsuario == $idUser) {

                            $iper2->setRole('OK');
                            $pepe = $iper2->getRole();
                            }
                    }

                    $idUser = print_r($idUser,true);
                    $idUserName = print_r($idUserName,true);
                    $idUserSurName = print_r($idUserSurName,true);



                    $arrayUsers['id']=$idUser;
                    $arrayUsers['name']=$idUserName;
                    $arrayUsers['surname']=$idUserSurName;
                    $arrayUsers['email']=$idUserEmail;


                    $catList[] = $arrayUsers;



                    $data= array(
                        "status"=>"success",
                        "code"=>200,
                        "data"=>$catList,
                        "users"=>$Users,
                        'rol' =>$descripcionRol


                    );
                }
                //$json = $json."]";
            }else{
                $data= array(
                    "status"=>"success",
                    "code"=>200,
                    "data"=>null,


                );
            }



            //  echo json_encode($catList);

            // $permJson = $helpers->json($json);
            // echo json_encode($json);



        }else{
            $data= array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"credenciales invalidas"

            );

        }

        return $helpers->json($data);

    }

    /**
     * Funcion para marcar un rol como Inactivo
     * @param string $uId Id de usuario Opcional en el request. para quitar el rol al usuario
     * @param string $id id de Rol para Inhabilitar o quitar del usuario
     * @return $data {
            "status"=>"status",
            "code"=> code,
            "msg / Objeto"=>"msg/objeto"'}
     */
    public function EliminarRolAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        $idUser = $request->get('uId',null);
        //compruebo que el token sea valido. @todo comprobar que sea Admin
        $authCheck = $jwt_auth->checkToken($token);



        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);


            $em = $this->getDoctrine()->getManager();

         if($idUser){
             //aca borraria la relacion entre el usuario y el rol.
             $rolxUser1 = $em->getRepository('BackendBundle:RolesXUser')->findOneBy(array(
                 "userid"=>$idUser,
                 "rolid"=>$id
             ));

             $em->remove($rolxUser1);
             $em->flush();

             $data = array(
                 "status"=>"success",
                 "code"=>200,
                 "data"=>$rolxUser1);



         }else{
             //aca va el update a inactivo


             $role = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                 "rolId" => $id
             ));

             $esatdoActual = $role->getEstado();

             if($esatdoActual==='Inactivo'){
                 $role->setEstado("Activo");
             }else{
                 $role->setEstado("Inactivo");
             }


             $em->flush();

                 $data = array(
                     "status" => "success",
                     "code" => 200,
                     "data" => $role,


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
