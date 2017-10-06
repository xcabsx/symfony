<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use BackendBundle\Entity\Task;
use BackendBundle\Entity\User;


class TaskController extends Controller
{
	public function newAction(Request $request, $id = null){

		echo "hola desde controlador de tareas";
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
					$title = (isset($params->title)) ? $params->title : null;
					$description = (isset($params->description)) ? $params->description: null;
					$status = (isset($params->status)) ? $params->status : null;
					

					if($userId != null && $title != null){
						//instancia entity manager!!.
						$em = $this->getDoctrine()->getManager();

						//busca en la tabla de usuarios por ID.
						$user = $em->getRepository('BackendBundle:User')->findOneBy(array(
							"id" => $userId
							));

						if($id == null){

							$task = new Task();
								$task->setUser($user);
								$task->setTitle($title);
								$task->setDescription($description);
								$task->setStatus($status);
								$task->setCreatedAt($createdAt);
								$task->setUpdatedAt($updatedAt);

									$em->persist($task);
									$em->flush();

									$data= array(
									"status"=>"success",
									"code"=>200,
									"data"=>$task
									);
						}else{

								$task = $em->getRepository('BackendBundle:Task')->findOneBy(array(
								"id"=> $id
								));

							if(isset($identity->sub) && $identity->sub == $task->getUser()->getId()){
								

										$task->setTitle($title);
										$task->setDescription($description);
										$task->setStatus($status);
										$task->setUpdatedAt($updatedAt);

										$em->persist($task);
										$em->flush();

										$data= array(
										"status"=>"success",
										"code"=>200,
										"data"=>$task
										);



							}else{
								$data= array(
								"status"=>"error",
								"code"=>400,
								"message"=>"no eres el dueño de la tarea"
								);	
							}


						}	

						
					}else{
						$data= array(
						"status"=>"error",
						"code"=>400,
						"message"=>"tarea no creada,validation failed"
						);

					};

					
				}else{

					$data= array(
					"status"=>"error",
					"code"=>400,
					"message"=>"tarea no creada, error de parametro"
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

public function tasksAction(Request $request){
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

				$dql = "SELECT t FROM BackendBundle:Task t WHERE t.user = {$identity->sub}  ORDER BY t.id DESC";
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

public function taskAction(Request $request , $id = null){

	$helpers = $this->get(Helpers::class);
	$jwt_auth = $this->get(JwtAuth::class);
	$token = $request->get('authorization',null);

			//compruebo que el token sea valido.
			$authCheck = $jwt_auth->checkToken($token);

			if($authCheck){
				$identity = $jwt_auth->checkToken($token,true);
				$em = $this->getDoctrine()->getManager();

				$task = $em->getRepository('BackendBundle:Task')->findOneBy(array(
					'id'=>$id
					));

				if($task && is_object($task) && $identity->sub == $task->getUser()->getId()){

					$data = array(
					"status"=>"success",
					"code"=>200,
					"data"=>$task


					);


				}else{
					$data = array(
					"status"=>"Error",
					"code"=>404,
					"message"=>"tarea no encontrada"
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

public function searchAction(Request $request, $search = null){

	$helpers = $this->get(Helpers::class);
	$jwt_auth = $this->get(JwtAuth::class);
	$token = $request->get('authorization',null);

			//compruebo que el token sea valido.
			$authCheck = $jwt_auth->checkToken($token);

		if($authCheck!= null){

			$identity = $jwt_auth->checkToken($token,true);

			$em = $this->getDoctrine()->getManager();


			//filtro.
			$filter = $request->get('filter',null);
			if(empty($filter)){
				$filter = null;
			}else if($filter == 1){
				$filter = 'activa';
			}else if($filter == 2){
				$filter = 'en espera';
			}else{
				$filter = 'terminada';
			}

			//orden
			$order = $request->get('order',null);
			if(empty($order) || $order == 2){
				$order = 'DESC';
			}else{
				$order = 'ASC';
			}

			//seach
			
			if($search != null){
				$dql= "SELECT t FROM BackendBundle:Task t "
				." WHERE t.user = $identity->sub AND "
				." (t.title LIKE :search OR t.description LIKE :search) ";

			
			}else{
				$dql = "SELECT t FROM BackendBundle:Task t"
				." WHERE t.user = $identity->sub ";
						
			}

			//set filtro

			if($filter != null){
					$dql .= " and t.status = :filter";
				}

			//set orden

			$dql .=" ORDER BY t.id $order";


			// create query
			$query = $em->createQuery($dql);

				//set parameter filter
			if ($filter != null) {
				$query->setParameter('filter',"$filter");
			}
			//set parameter search
			if(!empty($search)){
				$query->setParameter('search', "%$search%");
			}

			$tasks = $query->getResult();			


			$data= array(
				'status'=>'success',
				'code'=>200,
				'data'=>$tasks
				);

		}else{
			$data= array(
				'status'=>'error',
				'code'=>400,
				'message'=>'autoricacion invalida'
				);
		}
		return $helpers->json($data);
}

public function removeAction(Request $request, $id = null){
	$helpers = $this->get(Helpers::class);
	$jwt_auth = $this->get(JwtAuth::class);
	$token = $request->get('authorization',null);

	//compruebo que el token sea valido.
	$authCheck = $jwt_auth->checkToken($token);

			if($authCheck){
				$identity = $jwt_auth->checkToken($token,true);
				$em = $this->getDoctrine()->getManager();

				$task = $em->getRepository('BackendBundle:Task')->findOneBy(array(
					'id'=>$id
					));

				if($task && is_object($task) && $identity->sub == $task->getUser()->getId()){

					//eliminar tarea
					$em->remove($task);
					$em->flush();

					$data = array(
					"status"=>"success",
					"code"=>200,
					"data"=>$task


					);


				}else{
					$data = array(
					"status"=>"Error",
					"code"=>404,
					"message"=>"tarea no encontrada"
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

}