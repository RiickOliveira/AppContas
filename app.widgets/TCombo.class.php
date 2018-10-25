<?php

	class TCombo extends Tfield{

		private $itens;

		function __construct($name){

			parent::__construct($name);
			//cria uma tag html do tipo select
			$this->tag = new TElement('select ');
			$this->tag->class = 'tfield'; 

		}
		//adiciona itens ao combo box (array)
		function addItens($itens){

			$this->itens = $itens;
		}

		function show(){

			$this->tag->name = $this->name;
			$this->tag->style = "width:{$this->size}";

			$option = new TElement('option');
			$option->add('');
			$option->value = '0';
			//adiciona a opcao ao combo
			$this->tag->add($option);

			if ($this->itens){
				//percorre os itens adicionados
				foreach ($this->itens as $chave => $item) {
					$option = new TElement('option');
					$option->value = $chave;//define o indice da opcao
					$option->add($item);//adiciona o texto da opcao

					//caso seja a opcao selecionada
					if($chave == $this->value){
						//seleciona o item da combo
						$option->selected = 1;
					}
					//adiciona a opcao ao combo
					$this->tag->add($option);
				}
			}
			
			if (!parent::getEditable()){

				$this->tag->readonly = '1';
				$this->tag->class = 'tfield_disabled'; //classe css
			}

			$this->tag->show();
		}
	}



?>