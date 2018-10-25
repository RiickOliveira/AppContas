<?php

	class TTable extends TElement{

		function __construct(){

			parent::__construct('table');
		}

		//AGREGA UM NOVO OBJETO LINHA (TABLE.ROW) NA TABELA
		function addRow(){

			$row = new TTableRow;
			//ARMAZENA NO ARRAY DE LINHAS
			parent::add($row);

			return $row;
		}

	}




?>