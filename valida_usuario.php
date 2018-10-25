<?php

	function __autoload($classe){
    
    $pastas = array('app.widgets', 'app.ado');
    foreach ($pastas as $pasta)
    {
        if (file_exists("{$pasta}/{$classe}.class.php"))
        {
            include_once "{$pasta}/{$classe}.class.php";
        }
    }
}

	class UsuariosRecord extends TRecord{}

	try{
		
		$login = $_POST['login'];
		$senha = $_POST['senha'];

		TTransaction::open('my_appcontas');
		TTransaction::setLogger( new TLoggerTXT('C:\Users\Ricardo\Desktop\log5.txt'));

		TTransaction::log("* INICIANDO TRANSAÇAO");

		$repositorio = new TRepository('usuarios');

		$criteria = new TCriteria;
		$criteria->add(new TFilter('login','=',$login));
		$criteria->add(new TFilter('senha','=',$senha));
		
		$usuario = $repositorio->load($criteria);
		if($usuario){
			session_name('AppContas');
			session_start();
			$_SESSION['login'] = $login;
			$_SESSION['senha'] = $senha;
			header('location:home.php');
		} else {
			echo "<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='index.php';</script>";
			session_name('AppContas');
			session_start();
			unset ($_SESSION['login']);
			unset ($_SESSION['senha']);
			session_destroy();
			exit();		
		} 

		TTransaction::close();
		

	} catch (Exception $e){
		echo "erro" . $e->getMessage();
		TTransaction::rollback();
	}





?>