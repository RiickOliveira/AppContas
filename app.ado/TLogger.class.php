<?php
	/*
	 * RODRIGO OLIVEIRA - 17/04/2009 - 16:33
	 * 
	 * classe TLogger
	 * esta classe prove uma maneira abstrata para para definicao de algoritmos
	 * delog
	 * 
	 */
	abstract class TLogger{
		protected $filename; //local do arquivo de log
		
		/*
		 * metodo __construct
		 * instancia um logger
		 * @param $filename = local do arquivo de LOG
		 */
		public function __construct($filename){
			$this->filename = $filename;
			//reseta o conteudo do arquivo
			file_put_contents($filename,'');
		}
		
		/*
		 * define o metodo write como obrigatorio
		 */
		abstract function write($mensagem);
	}
?>