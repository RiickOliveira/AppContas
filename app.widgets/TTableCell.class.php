<?PHP

	class TTableCell extends TElement {

		//$value = conteudo da celula que sera exibida na tabela
		function __construct($value){

			parent::__construct('td');
			parent::add($value);
		
		}
	}

?>