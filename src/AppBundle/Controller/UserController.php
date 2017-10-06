<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use BackendBundle\Entity\User;


class UserController extends Controller{

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

        	$emailConstraint = new Assert\Email;
        	$emailConstraint->message = "Email no valido";
        	$validate_email = $this->get("validator")->validate($email,$emailConstraint);

        	if($email != null && count($validate_email)==0 && $password != null && $name != null && $surname != null ){
        		
        		$user = new User();
        			$user->setCreatedAt($createdAt);
        			$user->setRole($role);
        			$user->setName($name);
        			$user->setSurname($surname);
        			$user->setEmail($email);
        			

        			//cifrer contraseña
        			$pwd = hash('sha256',$password);
        			$user->setPassword($pwd);


        			$em = $this->getDoctrine()->getManager();/*manager para hacer consultas a la base*/
        			$isset_user = $em->getRepository('BackendBundle:User')->findBy(array(
        				"email"=>$email
        				));
        			/*busqueda en la base por email.*/

        			if(count($isset_user) == 0){
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
				$user = $em->getRepository('BackendBundle:User')->findOneBy(array(
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
		        			
		        			$isset_user = $em->getRepository('BackendBundle:User')->findBy(array(
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

}


    

