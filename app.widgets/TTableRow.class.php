<?php

	//CLASSE RESPONSAAVAEL PELA EXIB DE UMA LINHA NA TABELA
	class TTableRow extends TElement{

		function __construct(){

			parent::__construct('tr');
		}

		//AGREGA UM NOVO OBJETO CELULA(TABLE.CELL) A LINHA

		function addCell($value){

			$cell = new TTableCell($value);
			parent::add($cell);

			return $cell;
		}



}
?>