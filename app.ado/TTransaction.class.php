<?php
	/*
	 * RODRIGO OLIVEIRA 17/04/2009 - 08:50
	 * classe TTRansaction
	 * Classe que prove metodos necessarios paramanipular transacoes
	 */

	final class TTransaction{
		private static $conn; //conexao ativa
		private static $logger; // objeto de Log
		
		/*
		 * metodo construtor (__construct)
		 * Declarado como private para impedir que se crie instancias de TTransaction
		 */
		private function __construct(){}
		/*
		 *metodo open()
		 *Abre uma transacao em uma conexao com o bd
		 *@param $database = nome do banco de dados 
		 */
		public static function open($database){
			//abre uma conexao e armazena na propriedade estatica $conn
			if(empty(self::$conn)){
				self::$conn = TConnection::open($database);
				//inicia a transacao
				self::$conn->beginTransaction();
				//desliga o log de SQL
				self::$logger = NULL;
			}
		}
		
		/*
		 * metodo get()
		 * retorna a conexao ativa da transacao
		 */
		public static function get(){
			//retorna a conexao ativa
			return self::$conn;
		}
		
		/*
		 * metodo rollback()
		 * desfaz todas as operaçoes realizadas durante a transacao
		 */
		public static function rollback(){
			if (self::$conn){
				//desfaz as operacoes realizadas durante a transacao
				self::$conn->rollBack();
				self::$conn = NULL;
			}
		}
		
		/*
		 * metodo close
		 * aplica todas as operacoes realizada e fecha a transacao
		 */
		public static function close(){
			if (self::$conn){
				//aplica as operacoes realizadas
				self::$conn->commit();
				//fecha a conexao
				self::$conn = NULL;
			}
		}
		
		/*
		 * metodo setLogger
		 * define qual tipo de Log utilizar		 		 
		 */
		public static function setLogger(TLogger $logger){
			self::$logger = $logger;
		}
		
		/*
		 * metodo Log
		 * escreve uma mensagem no arquivo de Log se baseando na
		 * estrategia de Logger atual
		 */
		
		public static function log($mensagem){
			//verifica se existe um logger
			if(self::$logger){
				self::$logger->write($mensagem);
			}
		}
	}
?>