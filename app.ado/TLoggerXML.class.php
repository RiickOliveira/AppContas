<?php
	/*
	 * RODRIGO OLIVEIRA 17/04/2009 - 16:42
	 * 
	 * classe TLogger XML
	 * implementa o algoritmo de log em XML
	 */
	class TLoggerXML extends TLogger{
		/*
		 * metodo write
		 * escreve uma mensagem no log
		 * @param $message = mensagem a ser escrita
		 */
		public function write($mensagem){
			$time = date('d/m/Y - H:i:s');
			//monta a string
			$text = "<?xml version='1.0' encoding='ISO-8859-1'?>\n<log>\n";
			$text .= "<data>$time</data>\n";
			$text .= "<mensagem>$mensagem</mensagem>\n";
			$text .= "</log>\n";
			
			//adiciona ao final do arquivo
			$arquivo = fopen($this->filename,'a+');
			fwrite($arquivo,$text);
			fclose($arquivo);
		}
	}
?>