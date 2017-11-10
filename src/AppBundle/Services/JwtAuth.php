<?php
namespace AppBundle\Services;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\DoctrineBundle\ManagerConfigurator;
use Firebase\JWT\JWT;
use Doctrine\ORM\Query;
use stdClass;

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

        /** @var boolean Se carga true cuando el usuario existe en la base. */
        $signup = false;

        /**
         *Si $user es Objeto . encontro un usuario en la base con lso parametros pasados.
         */
		if(is_object($user)){
			$signup = true;

            /** @var Object Se buscan los permisos que tenga el usuario .
             *  @var $user ->getId() string Id de usuario
             *  @Return  Objeto Con lso permisos por Usuario.
             */
            $PermisosXuser = $this->manager->getRepository('BackendBundle:UsuarioXPermiso')->findBy(array(
                'idUsuario' => $user->getId()
            ));
            /** @var array Arreglo de accesos de la tabla directa. (excepciones) */
            $accesosExcepcion = array();
            foreach ($PermisosXuser as $iValue) {

                $accesosExcepcion[] = $iValue->getIdPermiso()->getNombrePermiso();
            }


            $rolesXuser = $this->manager->getRepository('BackendBundle:RolesXUser')->findBy(array(
                'userid' => $user->getId()
            ));
            if(!$rolesXuser){
                $accesos = array();
                $permisos = array();
                $roles = array();
            }else{
            foreach ($rolesXuser as $iValue2) {


               $permisos[] = $this->manager->getRepository('BackendBundle:PermisosXRol')->findBy(array(
                    'idRol' => $iValue2->getRolid()->getRolId()
                ));

               $aplicaciones[] =  $this->manager->getRepository('BackendBundle:AplicacionXRol')->findBy(array(
                    'idrol' => $iValue2->getRolid()->getRolId()
                ));
               $roles[] = $iValue2->getRolid()->getDescRol();


            }


// hacer q funcione con varios roles.... desde aca


            }
            //var_dump($accesos);
            //die();

            if(!$permisos ){

                $accesos = array();
            }else{
                foreach ($permisos as $ipermis) {
                    foreach ($ipermis as $pepe){
                        $accesos[] = $pepe->getIdPermiso()->getNombrePermiso();
                    }
                }
            }

            if(!isset($aplicaciones) ){

                $apls = array();
            }else{
                foreach ($aplicaciones as $iapliss) {
                   foreach ($iapliss as $ppe){
                        $apls[] = $ppe->getIdapl()->getDescripcionApl();
                    }

                }
            }



		}
		if($signup == true){

            /** @var array el merge de los permisos por rol y los exepcionales */
            $resultado = array_merge($accesosExcepcion, $accesos);

            /** @var array array de permisos sin duplicados */
            $resultado2 = array_keys(array_flip($resultado));




            //generar token

			$token = array(
				'sub' => $user->getId(),
				'email' => $user->getEmail(),
				'name' => $user->getName(),
				'surname' => $user->getSurname(),
				'iat' => time(),
				'exp' =>time()+(7 * 24 * 60 * 60),
				'Permisos' =>$resultado2,
                'Apls'=>$apls
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