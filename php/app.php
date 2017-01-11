<?php

include_once 'dao.php';

	/*
		Este fichero va a contener funciones que se utilizaran en otros ficheros php
	*/
		class App{

			protected $dao;

			function __construct(){
				$this->dao = new InventoryDao();
			}

			function head($titulo="", $h1="", $h2=null){
			echo '<!DOCTYPE html>
					<html lang="es">
  						<head>
						  	<meta name="viewport" content="width=device-width, initial-scale=1">
    						<meta charset="utf-8" />
    						<title>'.$titulo.'</title>
    						<link rel="stylesheet" type="text/css" href="../css/estilo.css" />'
							//<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
							.'
  						</head>

  					<body>

    					<header>
  	 						<h1>'.$h1.'</h1>
      						<h2>'.$h2.'</h2>
    					</header>
						';
			}

			function nav($currentPage){
				echo '<nav id ="principal">
      						<ul>';
        						echo '<li><a href="../index.php" '; 
									if($currentPage=="index"){echo 'class="selected"';}
								echo '>Principal</a></li>'; 

								if($this->isLogged()){
									echo '<li><a href="logout.php" '; 
									echo '>Cerrar sesión</a></li>';
								}
								
      						echo '</ul>
    					</nav>

    					<nav id="secundaria">
      						<ul>';
        					if($currentPage == "inventory"){
								echo '<li><a href="addproduct.php">Añadir producto</a></li>';
							}

							if($currentPage == "addproduct"){
								echo '<li><a href="inventory.php">Inventario</a></li>';
							}
      						echo '</ul>
    					</nav>
    					<div id="content">';
			}

    					

		function footer(){
			echo 	'
					</div>
					<footer>
      					<p>Pagina realizada por: Daniel Acedo</p>
    				</footer>
  				</body>
			</html>';
		}

		/**
		* Funcion que comprueba si el usuario ha iniciado sesión en la web
		*/
	function isLogged(){
		if(!isset($_SESSION['user'])){
			return false;
		}

		return true;
	}

	/**
	* Funcion que inicia la sesion y si no está logeado
	* redirecciona al login
	*/
	function start_session(){
		session_start();
		if(!$this->isLogged()){
			header("Location: login.php");
		}
	}

	/**
	* Función que inicia sesión en la página
	*/
	function init_session($user){
		if(!isset($_SESSION['user'])){
			$_SESSION['user'] = $user;
		}
	}

	/*
	* Función que cierra sesión
	*/
	function close_session(){
		if(isset($_SESSION['user'])){
			$_SESSION['user'] = null;
			session_destroy();
			header("Location: ../index.php");
		}
	}

	function showErrorConnection(){
		return $this->dao->error;
	}

	public function getDao(){
		return $this->dao;
	}

	public function goToInventory(){
		header("Location: inventory.php");
	}

	}

?>