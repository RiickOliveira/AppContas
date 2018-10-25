<?php
	/*
	 *Classe TExpression 
	 * Classe abstrata para gerenciar expressoes
	 */

	abstract class TExpression{
		//operadores logicos
		const AND_OPERATOR = 'AND';
		const OR_OPERATOR = 'OR';
		//marca Dump como obrigatorio
		abstract public function dump(); 
	} 
?>