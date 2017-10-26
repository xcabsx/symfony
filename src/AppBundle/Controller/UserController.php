<?php

namespace AppBundle\Controller;

use BackendBundle\Entity\Roles;
use BackendBundle\Entity\RolesXUser;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use BackendBundle\Entity\Users;


class UserController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
        	$role = 'user';
        	$email = (isset($params->email)) ?$params->email : null;
        	$name = (isset($params->name)) ? $params->name : null;
        	$surname = (isset($params->surname)) ? $params->surname : null;
        	$password = (isset($params->password)) ? $params->password : null;
        	$estado = 'Activo';

        	$emailConstraint = new Assert\Email;
        	$emailConstraint->message = "Email no valido";
        	$validate_email = $this->get("validator")->validate($email,$emailConstraint);

            if($email != null && count($validate_email)==0 && $password != null && $name != null && $surname != null ){

                /** @var Users usuario a grabar o modificar  */
                $user = new Users();
        		$user->setCreatedAt($createdAt);
        		$user->setRole($role);
        		$user->setName($name);
        		$user->setSurname($surname);
        		$user->setEmail($email);
                $user->setEstado($estado);


                /** @var string Password cifrado con sha256 */
                $pwd = hash('sha256',$password);
                $user->setPassword($pwd);


                /** @var EntityManager Entity manager de doctrine */
                $em = $this->getDoctrine()->getManager();
                /** @var Roles Traigo el rol Nuevo, que es el rol base para cada usuario nuevo. */
                $rolNuevo = $em->getRepository('BackendBundle:Roles')->findOneBy(array(
                    "descRol"=>'Nuevo'
                ));
                /** @var RolesXUser instancia de rolesXusuario para otorgar el rol "Nuevo" al usuario a grabar. */
                $rolesXuser = new RolesXUser();

                /** @var Users Comprueba si hay algun usuario en la base con ese email */
                $isset_user = $em->getRepository('BackendBundle:Users')->findBy(array(
        				"email"=>$email
        				));

        			if(count($isset_user) == 0){
        			    $rolesXuser->setRolid($rolNuevo);
        			    $rolesXuser->setUserid($user);

        			    $em->persist($rolesXuser);
        				$em->persist($user);
        				$em->flush();

        					$data = array(
						     'status'=> 'success' ,
						     'code'=> 200,
						     'msg'=>'User created',
						     'user'=>$user
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



    public function editAction(Request $request){
    	$helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);

        $token = $request->get("authorization",null);
        $autCheck = $jwt_auth->checkToken($token);

        if($autCheck){
				$em = $this->getDoctrine()->getManager();/*manager para hacer consultas a la base*/
				//datos del ususario logeado
				$identity = $jwt_auth->checkToken($token, true);

				//buscar usuario logeado en la base
				$user = $em->getRepository('BackendBundle:Users')->findOneBy(array(
					'id'=> $identity->sub
					));

		        //datos del post
		        $json = $request->get("json",null);
		        $params = json_decode($json);
		        
		        //array error por defecto
		        $data = array(
		        	'status'=> 'error' ,
		        	'code'=> 400,
		        	'msg'=>'User not updated'
		        	);



		        if( $json != null){

		        	//$createdAt = new \DateTime("now");
		        	$role = 'user';
		        	$email = (isset($params->email)) ?$params->email : null;
		        	$name = (isset($params->name)) ? $params->name : null;
		        	$surname = (isset($params->surname)) ? $params->surname : null;
		        	$password = (isset($params->password)) ? $params->password : null;

		        	$emailConstraint = new Assert\Email;
		        	$emailConstraint->message = "Email no valido";
		        	$validate_email = $this->get("validator")->validate($email,$emailConstraint);

		        	if($email != null && count($validate_email)==0 && $password != null && $name != null && $surname != null ){
		        		
		        		//setea el usuario que sacamos de la base de datos
		        			
		        			$user->setRole($role);
		        			$user->setName($name);
		        			$user->setSurname($surname);
		        			$user->setEmail($email);
		        			//$user->setPassword($password);
		        			if($password != null){
		        			$pwd = hash('sha256',$password);
        					$user->setPassword($pwd);
        					}
		        			
		        			$isset_user = $em->getRepository('BackendBundle:Users')->findBy(array(
		        				"email"=>$email
		        				));
		        			/*busqueda en la base por email.*/

		        			if(count($isset_user) == 0 || $identity->email == $email){
		        				$em->persist($user);
		        				$em->flush();

		        					$data = array(
								     'status'=> 'success' ,
								     'code'=> 200,
								     'msg'=>'User actualizado',
								     'user'=>$user
								      );

		        			}else{
		        				 $data = array(
							     'status'=> 'error' ,
							     'code'=> 400,
							     'msg'=>'User no actualizado duplicado'
							      );

		        			}



		        	}
		        }

        }else{

        		$data = array(
				    'status'=> 'error' ,
				    'code'=> 400,
				    'msg'=>'Autorizacion no valida!!'
				);

        }

       

        return $helpers->json($data);
    }

    public function usersAction(Request $request){
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

            $dql = "SELECT t FROM BackendBundle:Users t ";
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
    public function userAction(Request $request , $id = null){

        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);
        $token = $request->get('authorization',null);

        //compruebo que el token sea valido.
        $authCheck = $jwt_auth->checkToken($token);

        if($authCheck){
            $identity = $jwt_auth->checkToken($token,true);
            $em = $this->getDoctrine()->getManager();

            $User = $em->getRepository('BackendBundle:Users')->findOneBy(array(
                'id'=>$id
            ));

            if($User && is_object($User) ){

                $data = array(
                    "status"=>"success",
                    "code"=>200,
                    "data"=>$User


                );


            }else{
                $data = array(
                    "status"=>"Error",
                    "code"=>404,
                    "message"=>"Usuario no encontrado"
                );

            }

        }else{

            $data = array(
                "status"=>"Error",
                "code"=>400,
                "message"=>"fallo autenticacion"
            );
        }

        return $helpers->json($data);

    }

    public function EliminarUserAction(Request $request, $id){
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);


        //traigo el parametro del post.
        $token = $request->get('authorization',null);
        $idUser = $request->get('uId',null);
        // aca se puede poner los deletes de las relaciones mandando el id de la relacion a borrar
        //compruebo que el token sea valido. @todo comprobar que sea Admin
        $authCheck = $jwt_auth->checkToken($token);



        if($authCheck){
            //identity son los datos decritados del token
            $identity = $jwt_auth->checkToken($token,true);


            $em = $this->getDoctrine()->getManager();

            if($idUser=== 'pepe'){
                //no mando id! error.
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


                $user = $em->getRepository('BackendBundle:Users')->findOneBy(array(
                    "id" => $id
                ));

                $esatdoActual = $user->getEstado();

                if($esatdoActual==='Inactivo'){
                    $user->setEstado("Activo");
                }else{
                    $user->setEstado("Inactivo");
                }


                $em->flush();

                $data = array(
                    "status" => "success",
                    "code" => 200,
                    "data" => $user,


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


    

