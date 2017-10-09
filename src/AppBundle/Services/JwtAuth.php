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
		
		$user = $this->manager->getRepository('BackendBundle:Users')->findOneBy(array(
            'email' => $email,
				'password' =>$password
			));

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

            $PermisosXuser = $this->manager->getRepository('BackendBundle:UsuarioXPermiso')->findBy(array(
                'idUsuario' => $user->getId()
            ));
            /** @var array Arreglo de accesos de la tabla directa. (excepciones) */
            $accesosExcepcion = array();
            foreach ($PermisosXuser as $iValue) {

                $accesosExcepcion[] = $iValue->getIdPermiso()->getDescripPermiso();
            }
           /* var_dump($accesosExcepcion);
            die();*/


            $rolesXuserxaplic = $this->manager->getRepository('BackendBundle:RolXUsuarioXAplicacion')->findBy(array(
                'userid' => $user->getId()
            ));

            foreach ($rolesXuserxaplic as $iValue1) {
                $roles[] = $iValue1->getRolid()->getDescRol();
                $rolesIds[] =  $iValue1->getRolid()->getRolId(); // de aca los roles
            }

            for($i=0, $iMax = count($rolesIds); $i< $iMax; ++$i){

            $rol = $rolesIds[$i];
                $rolesXpermXaplication = $this->manager->getRepository('BackendBundle:RolPermisoAplicacion')->findBy(array(
                    'idrol' => $rolesIds[$i]

                ));
                foreach ($rolesXpermXaplication as $iValue) {
                    //var_dump($iValue->getIdpermiso()->getDescripPermiso());
                    $permisoss[] = $iValue->getIdpermiso()->getDescripPermiso();

                }


            }

            echo "pasa";
            var_dump($permisoss);
            //var_dump($rolesXpermXaplication->getRolid()->getDescRol());
            die();


            $permisos = $this->manager->getRepository('BackendBundle:PermisosXRol')->findBy(array(
                'idRol' => $rolesXuser->getRolid()->getRolId()
            ));



            //var_dump($rolesXuser->getRolid()->getDescRol()); //saco el rol;
            //var_dump($rolesXuser->getUserid()->getEmail()); //saco el nombre
            $accesos = array();


            foreach ($permisos as $iValue) {
                $accesos[] = $iValue->getIdPermiso()->getDescripPermiso();
            }


		}

		if($signup == true){

            $resultado = array_merge($accesosExcepcion, $accesos);
			//generar token
			$token = array(
				'sub' => $user->getId(),
				'email' => $user->getEmail(),
				'name' => $user->getName(),
				'surname' => $user->getSurname(),
				'iat' => time(),
				'exp' =>time()+(7 * 24 * 60 * 60),
				'Permisos' =>$resultado


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