<?php

	class TDataGridColumn {

		private $name,$label,$align,$width,$action,$transformer;

		/*instancia uma nova coluna
		* name = nome da coluna no bacno de dados
		* label = rotulo de texto que sera exibido
		* align = alinhamento da coluna left center right
		*/
		function __construct($name,$label,$align,$width){
			//atribui os parametros as propriedades do objeto
			$this->name = $name;
			$this->label = $label;
			$this->align = $align;
			$this->width = $width;
		}
		//retorna o nome da coluna no banco de dados
		function getName(){

			return $this->name;
		}
		//retorna o nome do rotulo de texto da coluna
		function getLabel(){

			return $this->label;
		}

		function getAlign(){

			return $this->align;
		}

		function getWidth(){

			return $this->width;
		}
		//define uma acao a ser executada quando 
		//o usuario clicar sobre o tiulo da coluna
		//$action = objeto TAction contendo a acao
		function setAction(TAction $action){

			$this->action = $action;
		}
		//retorna a acao vinculada a coluna
		function getAction(){
			//verifica se a colluna possui acao
			if ($this->action){
				return $this->action->serialize();
			}		
		}
		//define uma funcao (callback) a ser aplicada sobre todo dado
		//contido nessa coluna
		//$callback = funcao do PHP ou so usuario
		function setTransformer($callback){

			$this->transformer = $callback;
		}

		function getTransformer(){

			return $this->transformer;
		}
	}
?>