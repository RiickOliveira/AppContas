<?php

	//classe para encerrar a sessao com o usuario atual
	class FimSession extends TPage{

		function encerraSessao(){
			$action1 = new TAction(array($this,'apagaSessao'));
			$action2 = new TAction(array($this,'teste'));

			new TQuestion('Deseja realmente encerrar a seção?',$action1,$action2);
			
			
			}

		function apagaSessao(){

			if((isset ($_SESSION['login']) == true) and (isset ($_SESSION['senha']) == true)){
				
				  session_destroy();
				  unset($_SESSION['login']);
				  unset($_SESSION['senha']);
				  header('location:index.php');
			}
		}	

	}
	

?>