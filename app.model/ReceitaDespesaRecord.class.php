<?php

	class ReceitaDespesaRecord extends TRecord{

		private $categoria;

		//executado sempre se for acesssada a propriedade nome_categoria
		function get_nome_categoria(){
			//instancia categriaRecord, carrega na
			//memoria a cidade de codigo $this->id_categoria
			if (empty($this->categoria))
				$this->categoria = new CategoriaRecord($this->id_categoria);
			//retorna o objeto instanciado
			return $this->categoria->descricao;
		}
		function get_nome_pessoa(){
			//instancia cidadeRecord, carrega na
			//memoria a cidade de codigo $this->id_cidade
			if (empty($this->pessoa))
				$this->pessoa = new PessoaRecord($this->id_pessoa);
			//retorna o objeto instanciado
			return $this->pessoa->nome;
		}
		
	}

?>