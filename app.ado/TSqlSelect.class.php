<?php
	/*
	 * RODRIGO OLIVEIRA 16/04/2009 - 15:40
	 * 
	 * classe TSqlSelct
	 * classe que manipula acoes em um BD atraves da instrucao Select
	 */
	final class TSqlSelect extends TSqlInstruction{
		private $colunas; //array com as colunas a serem retornadas
		
		/**
		 * metodo addColuna
		 * adiciona uma coluna a ser retornada pelo select
		 * @param $coluna = coluna da tabela
		 */
		public function addColumn($coluna){
			//adiciona a coluna em um array
			$this->colunas[] = $coluna;
		}
		
		/**
		 * metodo getInstruction 
		 * retorna a isntrucao select em forma de string
		 */		
		public function getInstruction(){
			//monta a instrucao select
			$this->sql = 'SELECT ';
			//MONTA A string com o nome das colunas
			$this->sql .= implode(',',$this->colunas);
			//adiciona na clausula FROM o nome da tabela
			$this->sql .= ' FROM '.$this->entity;

			//obtem a clausula WHERE do objeto criteria
			if($this->criteria){
				$expression = $this->criteria->dump();
				if($expression){
					$this->sql .= ' WHERE '.$expression;	
				}
				//obtem as propriedades do criterio
				$ordem = $this->criteria->getProperty('order');
				$limite = $this->criteria->getProperty('limit');
				$offset = $this->criteria->getProperty('offset');
				
				//obtem a ordenacao do SELECT
				if ($ordem){
					$this->sql .= ' ORDER BY '.$ordem;
				}
				if ($limite){
					$this->sql .= ' LIMIT '.$limite;
				}
				if ($offset){
					$this->sql .= ' OFFSET '.$offset;
				}
			}
			return $this->sql;
		}
	}
?>