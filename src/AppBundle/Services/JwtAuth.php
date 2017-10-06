<?php
namespace AppBundle\Services;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\DoctrineBundle\ManagerConfigurator;
use Firebase\JWT\JWT;
use Doctrine\ORM\Query;

class JwtAuth{
	public $manager;
	public $key;
	public function __construct($manager){
		$this->manager = $manager;
		$this->key = 'clavesecreta123';
	}

	public function signup($email, $password, $getHash = null){
		
		$user = $this->manager->getRepository('BackendBundle:User')->findOneBy(array(
            'email' => $email,
				'password' =>$password
			));
		$rolesXuser = $this->manager->getRepository('BackendBundle:RolesXUser')->findOneBy(array(
				'userid' => $user->getId()
			));

		$permisos = $this->manager->getRepository('BackendBundle:PermisosXRol')->findBy(array(
				'idRol' => $rolesXuser->getRolid()->getRolId()
			));

		//var_dump($rolesXuser->getRolid()->getDescRol()); //saco el rol;
		//var_dump($rolesXuser->getUserid()->getEmail()); //saco el nombre
		$accesos = array();


        foreach ($permisos as $iValue) {
            $accesos[] = $iValue->getIdPermiso()->getDescripPermiso();
        }
		//var_dump($accesos);
		//$pepe1 = 'rolid:'.$roles->getRolid()->getRolId();
		//$pepe = $permisos->getIdPermiso();
		//var_dump($permisos->getIdPermiso()->getDescripPermiso());
		//var_dump($permisos[3]->getIdPermiso()->getDescripPermiso());
		/*var_dump($email);
		var_dump($password);*/
		$signup = false;
		if(is_object($user)){
			$signup = true;
		}

		if($signup == true){
			//generar token
			$token = array(
				'sub' => $user->getId(),
				'email' => $user->getEmail(),
				'name' => $user->getName(),
				'surname' => $user->getSurname(),
				'iat' => time(),
				'exp' =>time()+(7 * 24 * 60 * 60),
				'Permisos' =>$accesos


				);

			$jwt = JWT::encode($token,$this->key, 'HS256');
			$decoded = JWT::decode($jwt,$this->key,array('HS256'));

			if($getHash == null){
				$data = $jwt;
			}else{
				$data = $decoded;
			}

				//$data = $jwt;

			/*$data= array(
				"user"=>$user,
				"status"=>"succes"
				);*/
		}else{
			$data= array(
				'data' => 'fallo login',
				'status' => 'error'
				);

		}

		return $data;

	}

	public function checkToken($jwt,$getIdentity = false){
		$auth = false;
		$decoded = '';

		try{

			$decoded = JWT::decode($jwt,$this->key, array('HS256')) ;

		}catch(\UnexpectedValueException $e){
			$auth = false;
		}catch(\DomainException $e){
			$auth = false;
		}

		if(isset($decoded) && is_object($decoded) && isset($decoded->sub) ){
			$auth = true;
		}else{
			$auth = false;
		}

		if($getIdentity == false){
			return $auth;
		}else{
			return $decoded;
		}


	}
}