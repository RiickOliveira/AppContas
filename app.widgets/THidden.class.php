<?php

	class THidden extends TField{

		function show(){

			$this->tag->name =$this->name;
			$this->tag->value =$this->value;
			$this->tag->type = 'hidden';
			$this->tag->style = "width:{$this->size}";

			$this->tag->show();
		}
	}




?>