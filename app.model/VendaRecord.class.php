<?php
	
	class VendaRecord extends TRecord{

		private $itens; //array de objetos do tipo itemReccord

		//adiciona um item (produto) a venda
		function addItem(ItemRecord $item){

			$this->itens[] = $item;
		}
		//armazena uma venda e seus itens no banco de dados
		function store(){
			//armazena a venda
			parent::store();
			//percorre os itens da venda
			foreach ($this->itens as $item){

				$item->id_venda = $this->id;
				//armazena o item
				$item->store();
			}
		}
		//function get_itens() retorna os itens da venda
		function get_itens(){
			//instancia um repositorio de item
			$repositorio = new TRepository('Item');
			//define o criterio de selecao
			$criterio = new TCriteria;
			$criterio->add(new TFilter('id_venda','=',$this->id));
			//carrega a colecao de itens
			$this->itens = $repositorio->load($criterio);
			//retorna os itens
			return $this->itens;
		}
		//function get_cliente() retorna o objeto cliente vinculado a venda
		function get_cliente(){
			//instancia ClienteRecord, carrega na memoria
			//o cliente de codigo $this->id_cliente
			$cliente = new ClienteRecord($this->id_cliente);

			//retorna o objeto instanciado
			return $cliente;
		}
	}
?>