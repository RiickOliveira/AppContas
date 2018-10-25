<?php
	/*
	 * RODRIGO OLIVEIRA 16/04/2009 - 16:30
	 * 
	 * classe Tconnection
	 * gerencia conexoes com banco de dados atraves de arquivos de configuracao
	 * 
	 */
	final class TConnection {
		/*
		 * metodo __construct
		 * nao existirao instancias de TConnection, por isto marco como private
		 */
		private function __construct(){}
		
		/*
		 * metodo open
		 * recebe o nome do banco e instancia o objeto PDO correspondente
		 */
		public static function open($name){
			
			if (file_exists("app.config/{$name}.ini"))
			{
				$db = parse_ini_file("app.config/{$name}.ini");				
			} 
			else 
			{
				throw new Exception("ARQUIVO $name NAO ENCONTRADO");
			}

			$user = $db['user'];
			$pass = $db['pass'];
			$name = $db['name'];
			$host = $db['host'];
			$type = $db['type'];

		//descobre qual o tipo de driver de banco de dados a ser utilizado
		switch($type){
			case 'pgsql':
				$conn = new PDO("pgsql:dbname={$name};user={$user};password={$pass};host={$host}");
				break;

			case 'mysql': 
	 	         $conn = new PDO("mysql:host={$host}; port=3306; dbname={$name}", $user, $pass);
	 	         break;

			/*case 'db2':				
				$conn = new PDO("odbc:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$name;".
				                "HOSTNAME=$host;PORT=$port;PROTOCOL=TCPIP;UID=$user;PWD=$pass;",null,null);	*/
		}
		
		//define que o PDO lance exccoes na ocorrencia de erros
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		//retorna o objeto instanciado
		return $conn;
		}		
	}
?>