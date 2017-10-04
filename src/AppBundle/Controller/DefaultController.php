<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;


class DefaultController extends Controller
{
   
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function loginAction (Request $request){
        $helpers = $this->get(Helpers::class);
        
        //recibir json por post
        $json = $request->get('json',null);

        $data = array(
            'status' => 'error',
            'data'=>'send json via post!!'
            );

        if($json != null){
                      //convertimos un json del post a un objeto de php
            $params = json_decode($json);

            $email = (isset($params->email)) ? $params->email : null;
            $password = (isset($params->password)) ? $params->password : null;
            $getHash = (isset($params->getHash)) ? $params->getHash : null;
                //--validar el mail
            $emailConstraint = new Assert\Email();
            $emailConstraint->message ="no es un email valido";
            $validate_email = $this->get("validator")->validate($email,$emailConstraint);
                //--fin validar mail

            //cifrar contraseña
           
            $pwd = hash('sha256',$password);

            if(count($validate_email)==0 && $password != null){

                $jwt_auth = $this->get(JwtAuth::class);//llamo al servicio jwtauth

                if($getHash == null || $getHash == false){
                     $signup = $jwt_auth->signup($email,$pwd); //llamo el metodo sin parametro hash
                }else{
                      $signup = $jwt_auth->signup($email,$pwd, true);  
                }
                
                /*      $data = array(
                                'status' => 'succes',
                                'data'=>'Email correcto',
                                'signup'=>$signup );*/
                 return $this->json($signup);               


            }else{

                      $data = array(
                                'status' => 'error',
                                'data'=>'Email incorrecto' );

            }

              
           

        }else{

        }

        return $helpers->json($data);

    }


   
    public function pruebasAction(Request $request){
        echo "hola mundo con sinfoni3 <hr />";
        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);
        $token = $request->get("authorization",null);

    if($token && $jwt_auth->checkToken($token) == true ){
        
    $em = $this->getDoctrine()->getManager();
    $userRepo = $em->getRepository('BackendBundle:User');
    $users = $userRepo->findAll();

   
        
       // return $helpers->json($users[0]); 
        //die();
         return $this->json(array(
        'status' => 'success',
        'users' =>  $users[0]->getName()
        ));

    }else {

        return $this->json(array(
        'status' => 'error',
        'code' => 400,
        'data' =>  "Authorization not valid" ));

    }

    
}}
