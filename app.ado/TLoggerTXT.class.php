<?php
	/*
	 * RODRIGO OLIVEIRA 17/04/2009 - 16:55
	 * 
	 * classe TLogger TXT
	 * implementa o algoritmo de log em TXT
	 */
	class TLoggerTXT extends TLogger{
		/*
		 * metodo write
		 * escreve uma mensagem no log
		 * @param $message = mensagem a ser escrita
		 */
		public function write($mensagem){
			$time = date('d/m/Y - H:i:s');
			//monta a string
			$text = "$time :: $mensagem";
			
			//adiciona ao final do arquivo
			$arquivo = fopen($this->filename,"a");
			fwrite($arquivo,$text);
			fclose($arquivo);
		}
	}
?>