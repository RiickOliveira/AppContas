<?php  
	//gerencia uma sessao com o usuario
	class TSession{

		//inicializa uma sessao 
		function __construct(){

			session_start();
		}
		//armazena uma variavel na sessao
		static function setValue($var,$value){

			$_SESSION[$var] = $value;
		}
		//retorna uma variavel da sessao
		static function getValue($var){			
			
			if (isset($_SESSION[$var])){
				
				return $_SESSION[$var];
		}
		         		        		
		}
		//destroi os dados de uma sessao
		function freeSession(){

			$_SESSION = array();
			session_destroy();
		}
	}

?>