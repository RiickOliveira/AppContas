<?php

	function __autoload($classe){
    
    $pastas = array('app.widgets', 'app.ado','app.model','app.control');
    foreach ($pastas as $pasta){
        
        if (file_exists("{$pasta}/{$classe}.class.php")){
            
            include_once "{$pasta}/{$classe}.class.php";
       		}
   		}
	}

	class TApplication{

		static public function run(){
	
			if(!isset($_SESSION)) 
		    { 
		        session_name('AppContas');
		        session_start(); 
		    } 
			$logado = $_SESSION['login'];

			if((!isset ($_SESSION['login'])) and (!isset ($_SESSION['senha'])))
			{
			  unset($_SESSION['login']);
			  unset($_SESSION['senha']);
			  header('location:index.php');
			  }
			  echo "Seja bem vindo " .strtoupper($logado)."!";
			
			$content ='';
			$template = file_get_contents('template.html');
			if ($_GET){

				$class = isset($_GET['class']) ? $_GET['class'] : NULL;
            	$method = isset($_GET['method']) ? $_GET['method'] : NULL;
				
				if(class_exists($class)){

					$pagina = new $class;
					ob_start();
					$pagina->show();
					$content = ob_get_contents();
					ob_end_clean();
				} elseif (function_exists($method)){

					call_user_func($method,$_GET);
				}
			}
			echo str_replace('#CONTENT#',$content, $template);
		}
	}
	TApplication::run();

?>