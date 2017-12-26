<?php


	Class Session 
	{


		public $user; // $Id
		private $authenticated_user = false; // $logueado


		function __construct()
		{	// Inicio de la función construc()
			session_start();
			$this->login_verify(); // verificar_logueo()
		}	// Fin de la función __construct()

		public function login_verify()
		{

			if (isset($_SESSION["user"])) 
			{
				$this->user = $_SESSION["user"]; // $UserGuid
				$this->authenticated_user = true; // No logueado
			} 
			else 
			{
				unset($this->UserGuid); // $UserGuid
				$this->authenticated_user = false; // No logueado
			}


		}



		public function login_authorized() // esta_logueado()
		{	// Función que verifica si el usuario ya inicio sesión
			// Devuelve la bandera de autenticación
			return $this->authenticated_user; // $logueado
		} 	// Fin de la función login_authorized()


	}

	$session = new Session();

?>