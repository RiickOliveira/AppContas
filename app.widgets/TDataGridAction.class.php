<?php

	class TDataGridAction extends Taction{

		private $image,$label,$field;

		function setImage($image){

			$this->image = $image;
		}

		function getImage(){

			return $this->image;
		}
		//define o rotulo do texto da acao
		function setLabel($label){

			$this->label = $label;
		}

		function getLabel(){

			return $this->label;
		}
		//define o nome do campo no banco de dados que 
		//sera passado juntamente com a acao
		//$field = nome do campo no banco de dados
		function setField($field){

			$this->field = $field;
		}

		function getField(){

			return $this->field;
		}
	}
?>