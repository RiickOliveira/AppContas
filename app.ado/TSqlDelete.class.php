<?php
	/*
	 * Classe TSqlDelete
	 * classe que prove meios para manipulacao de instrucoes delete em DB's
	 */
	final class TSqlDelete extends TSqlInstruction{
		/*
		 * metodo getInstruction
		 * retorna a instrucao delete em forma de string
		 */
		public function getInstruction(){
			//monta a string delete
			$this->sql = "DELETE FROM {$this->entity}";
			
			//retorna a calusula WHERE
			if ($this->criteria){
				$expression = $this->criteria->dump();
				if ($expression){
					$this->sql .= " WHERE ".$expression;
				}
			}
			
			return $this->sql;
			
		} 
	}
?>