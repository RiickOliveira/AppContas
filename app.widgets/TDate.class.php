<?php

	class TDate extends TField{

		function show(){

			//ATRIBUI AS PROPRIEDADES DA TAG
			$this->tag->name = $this->name;
			$this->tag->value = $this->value;
			$this->tag->type = 'date';
			$this->tag->style = "width:{$this->size}";
		
			//se o campo nao é editavel
			if (!parent::getEditable()){

				$this->tag->readonly = '1';
				$this->tag->class = 'tfield_disabled'; //classe css
			}
			$this->tag->show();
		}
	}
?>