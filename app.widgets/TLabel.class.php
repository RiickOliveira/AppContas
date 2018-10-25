<?php

	class TLabel extends TField{

		private $fontSize,$fontFace,$fontColor;

		//INSTANCIO O LABEL CRIA UM OBJETO <font>
		function __construct($value){

			//atribui o conteudo do label
			$this->setValue($value);
			//instancia um elemento <font>
			$this->tag = new TElement('font');
			//define valores iniciais as propriedades
			$this->fontSize = '14';
			$this->fontFace = 'Arial';
			$this->fontColor = 'black';
		}

		function setFontSize ($size){

			$this->fontSize = $size;
		}

		function setFontFace($font){

			$this->fontFace = $font;
		}

		function setFontColor($color){

			$this->fontColor = $color;
		}

		function show(){

			//define o stilo da tag
			$this->tag->style = "font-family:{$this->fontFace}; ".
								"color:{$this->fontColor}; ".
								"font-size:{$this->fontSize}";

			//adiciona o contuedo a tag
			$this->tag->add($this->value);
			//exibe a tag
			$this->tag->show();

		}
	}





?>