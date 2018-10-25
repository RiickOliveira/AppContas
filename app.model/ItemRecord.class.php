<?php

	class ItemRecord extends TRecord{

		private $produto;
		
		//retorna a descricao do produto
		function get_descricao(){
			//instancia produtoRecord, carrega na memoria
			//o produto de codigo $this->id_prduto
			if (empty($this->produto))
				$this->produto = new ProdutoRecord($this->id_produto);
			//retorna a descriçao do produto
			return $this->produto->descricao;
		}
		//retorna o preco de venda do produto
		function get_preco_venda(){
			//instancia ProdutoRecord, carrega na memoria
			//o produto de codigo $this->id_produto
			if(empty($this->produto))
				$this->produto = new ProdutoRecord($this->id_produto);
			//retorna o preco do de venda do produto instanciado
			return $this->produto->preco_venda;
		}
	}
?>