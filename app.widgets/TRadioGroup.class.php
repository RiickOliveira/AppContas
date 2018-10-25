<?php
	
	class TRadioGroup extends TField{

		private $layout = 'vertical';
		private $itens;

		function setLayout($dir){

			$this->layout = $dir;
		}
	
		function addItens($itens){

			$this->itens = $itens;
		}

		function show(){

			if ($this->itens){
				//percorre cada uma das opcoes de radio
				foreach ($this->itens as $index => $label) {
					$button = new TRadioButton($this->name);
					$button->setValue($index);
					// se possui qualquer valor
					if ($this->value == $index){
						//marca o radio button
						$button->setProperty('checked','1');
					}
					$button->show();
					$obj = new TLabel($label);
					$obj->show();

					if($this->layout == 'vertical'){
						//exibe uma tag de quebra da linha
						$br = new TElement('br');
						$br->show();
					}
					echo "\n";
				}
			}
		}
	}




?>