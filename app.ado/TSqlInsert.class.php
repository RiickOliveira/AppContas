<?php
	/*
	 * RODRIGO OLIVERA 16/04/2009 - 10:04
	 * 
	 * Classe TsqlInsert
	 * esta classe prove meios para manipulacao da instrucao insert no BD
	 */
	
	final class TSqlInsert extends TSqlInstruction{
		/*
		 * metodo setRowData
		 * atribui valores a determinadas colunas no banco de dados que serao inseridas
		 */
		 public function setRowData($coluna,$value){
		 	//monta um array indexado pelo nome da coluna
		 	if (is_string($value)){
		 		//adiciona \ em aspas
		 		$value = addslashes($value);
		 		//caso seja uma string
		 		$this->valorColuna[$coluna] = "'$value'";
		 	}
		 	else if(is_bool($value)){
		 		//caso seja boolean
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
		  * metodo setCriteria
		  * nao existe no contexto dessa classe, logo ira lancar um erro se for
		  * executatado
		  */
		 public function setCriteria(TCriteria $criteria){
		 	//lanca o erro
		 	throw new Exception("Metodo setCriteria nao pode ser chamado em ".__CLASS__);
		 }
		 
		 /*
		  * metodo getInstruction
		  * retorna a isntrucao insert em forma de string
		  */
		public function getInstruction(){
			$this->sql = "INSERT INTO {$this->entity} (";
			//monta uma string conendo o nome das colunas
			$colunas = implode(',',array_keys($this->valorColuna));
			$values = implode(',',array_values($this->valorColuna));
			$this->sql.= $colunas. ')';
			$this->sql.= "VALUES ({$values})";
			
			return $this->sql;
		}
	}
?>