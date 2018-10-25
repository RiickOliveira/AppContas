<?php
	/**
	 * Classe Tfilter
	 * Esta classe prove uma interface para definicao de filtros
	 * de selecao
	 */
	class TFilter extends TExpression{
		private $variable;
		private $operator;
		private $value;
		
		/**
		 * metodo __construct
		 * instancia um novo filtro 
		 * @param $variable = variavel
		 * @param $operator = operador (>,<)
		 * @param $value = valor a ser comparado
		 */		
		public function __construct($variable,$operator,$value){
			//armazana as propriedades
			$this->variable = $variable;
			$this->operator = $operator;
			//transforma o valor de acrodo com as regras
			//antes de atribuir a variavel
			$this->value = $this->transform($value);
		}
		
		/**
		 * metodo transform
		 * recebe um valor e faz modificacoes necessarias
		 * podendo ser um string/integer/boolean/array
		 * @param $value = valor a ser transformado
		 */		
		private function transform($value){
			//caso seja um array
			if (is_array($value)){
				//percorre os valores
				foreach($value as $x){
					//se for um inteiro
					if(is_integer($x)){
						$foo[] = $x;
					}else if(is_string($x)){
						//adiciona aspas
						$foo[]="'$x'";
					}
				}
				//converte o array em string separada por virgula
				$result = '('.implode(',',$foo).')';
			//caso seja uma string
			}else if(is_string($value)){
				//adiciona aspas
				$result = "'$value'";
			//caso seja valor nulo					
			}else if(is_null($value)){
				//armazena null
				$result = 'NULL';
			//caso seja booleano	
			}else if(is_bool($value)){
				//armazena true ou false
				$result = $value ? 'TRUE' : 'FALSE';
			}else{
				$result = $value;
			}
			//retorna o valor
			return $result;
		}
		
		/**
		 * metodo dump()
		 * retorna filtro em forma de expressao
		 */
		public function dump(){
			//concatena a expressao
			return " {$this->variable} {$this->operator} {$this->value} ";
		}
	} 
?>