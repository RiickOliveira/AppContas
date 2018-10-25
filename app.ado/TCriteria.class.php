<?php
	/**
	 * Esta classe prove uma interface para defiicao de criterios
	 */
	class TCriteria extends TExpression{
		private $expressions; //expressoes
		private $operators; //operadores
		private $properties; //propriedades
		
		/**
		 * metodo add()
		 * adiciona uma expressao ao criterio
		 * @param $expression = expressao(objeto Texpression)
		 * @param $operator = operador logico de comparacao
		 */		
		public function add(TExpression $expression,$operator = self::AND_OPERATOR ){
			//na primeira vez nao precisaomos de operador logico para concatenar
			if (empty($this->expressions)){
				$operator=null;
			}
			
			//agrega o resultado da expressao à lista de expressoes
			$this->expressions[] = $expression;
			$this->operators[] = $operator;
		}	
		/**
		 * metodo dump()
		 * retorna a expressao final
		 */			
		public function dump(){
			//concatena a lista de expressoes
			$result = '';
			if (is_array($this->expressions)){
				foreach($this->expressions as $i=>$expression){
					$operator = $this->operators[$i];
					//concatena o operador com a respectiva expressao
					$result .= $operator.$expression->dump().' '; 
				}
				$result = trim($result);
				return "{$result}";
			}
		}
		
		/**
		 * metodo setProperty()
		 * define o valor de uma propriedade
		 * @param $property = propriedade
		 * @param $value = valor 
		 */		
		public function setProperty($property,$value){
			$this->properties[$property] = $value;
		}
		
		/**
		 * metodo getProperty()
		 * retorna o valor de uma propriedade
		 * @param $property = propriedade
		 */		
		public function getProperty($property){
			
			if (isset($this->properties[$property]))
        	{
            return $this->properties[$property];
        	}
		}
	}	
?>