<?php

	class ProdutoRecord extends TRecord{

		private $fabricante;

		//retorna o nome do fabricante do produto
		function get_nome_fabricante(){
			//instancia fabricanteRecord, carrega na memoria
			//a fabricante de codigo $this->id_fabricante
			if (empty($fabricante)){

				$this->fabricante = new FabricanteRecord($this->id_fabricante);
			//retorna o nome do fabricante
			return $this->fabricante->nome;
			}
		}
	}

?>