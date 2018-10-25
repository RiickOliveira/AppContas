<?php
	/*
	 * classe TSqlUpdate
	 * classe que prove manipulcao de dados atraves da clausula UPDATE
	 */
	final class TSqlUpdate extends TSqlInstruction{
		/*
		 * metodo setRowData
		 * Atribui valores a determinadas colunas no banco que serao modificadas
		 * @param $coluna = coluna da tabela
		 * @param $value = valor a ser armazenado
		 */
		public function setRowData($coluna,$value){
			//monta um array indexado pelo nome da coluna	
			if (is_string($value)){
				//adiciona \ em aspas
				$value = addslashes($value);
				
				//caso seja uma string 
				$this->valorColuna[$coluna] = "'$value'";
			}
			else if (is_bool($value)){
				//caso seja booleano
				$this->valorColuna[$coluna] = $value ? 'TRUE' : 'FALSE';
			}
			else if(isset($value)){
				//caso seja outro tipo de dado
				$this->valorColuna[$coluna] = $value;
			}else{
				//caso seja NULL
				$this->valorColuna[$coluna] = 'NULL';
			}
		}
		
		/*
		 * Metodo getInstruction
		 * retorna a instrucao UPDATE em forma de string		 * 
		 */
		public function getInstruction(){
			//monta a string de UPDATE
			$this->sql = "UPDATE {$this->entity}";
			//monta os pares coluna=valor
			if($this->valorColuna){
				foreach ($this->valorColuna as $coluna => $valor){
					$set[] = " {$coluna} = {$valor} ";
				}
			}
			$this->sql .= ' SET '.implode(',',$set);
			
			//retorna a clausula WHERE  do objeto this->criteria
			if ($this->criteria){
				$this->sql.= ' WHERE '.$this->criteria->dump();
			}
			
			return $this->sql;
		}
		
	} 
?>