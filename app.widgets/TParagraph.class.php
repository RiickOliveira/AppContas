<?php

	class TParagraph extends TElement {

		function __construct($text){

			parent::__construct('p');
			//ATRIBUI O CONTEUDO DO TEXTO
			parent::add($text);
		}

		function setAlign($align){

			$this->align = $align;
		}
	}





?>