<?php

	class TImage extends TElement {

		private $source;

		function __construct($source){

			parent::__construct('img');
			//ATRIBUI LOCALIZACAO DA IMAGEM
			$this->src = $source;
			$this->border = 0;
		}
	}
?>