<?php

	class TPassword extends TField{

		function show(){

			$this->tag->name =$this->name;
			$this->tag->value =$this->value;
			$this->tag->type = 'password';
			$this->tag->style = "width:{$this->size}";

			if (!parent::getEditable()){

				$this->tag->readonly = '1';
				$this->tag->class = 'tfield_disabled'; //classe css
			}

			$this->tag->show();
		}
	}



?>