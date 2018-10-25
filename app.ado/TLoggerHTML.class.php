<?php
	/**
	 * RODRIGO OLIVEIRA 17/04/2009 - 16:50	  
	 * classe TLogger HTML
	 * implementa o algoritmo de log em HTML
	 */
	class TLoggerHTML extends TLogger{
		/**
		 * metodo write
		 * escreve uma mensagem no log
		 * @param $message = mensagem a ser escrita
		 */
		public function write($mensagem){
			$time = date('d/m/Y - H:i:s');
			//monta a string
			$text = "<p>\n";
			$text .= "<b>$time :</b>\n";
			$text .="<i>$mensagem</i>\n";
			$text .= "</p>\n";
			
			//adiciona ao final do arquivo
			$arquivo = fopen($this->filename,'a+');
			fwrite($arquivo,$text);
			fclose($arquivo);
		}
	}
?>