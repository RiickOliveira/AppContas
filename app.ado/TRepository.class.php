<?php

	final class TRepository{
		private $class; // CLASSE Q SERA MANIPULADA PELO REPOSITORIO

		//metodo construct instancia um repositorio de objetos

		function __construct($class){
			
			$this->class = $class;
		}

		//metodo load recupera um conjunto de objetos(collection) do BD atraves de um criterio($criteria) de selecao e instancia-los em memoria
		function load(TCriteria $criteria){

			$results = array();
			$sql = new TSqlSelect;
			$sql->addColumn('*');
			$sql->setEntity($this->class);
			//atribui o criteria passado como parametro
			$sql->setCriteria($criteria);

			if ($conn = TTransaction::get()){

				TTransaction::log($sql->getInstruction());
				
				$result = $conn->query($sql->getInstruction());

				if ($result) {
					//percorre os resultados da consulrta , retornando um objeto
					while ($row = $result->fetchObject($this->class . 'Record')){

						$results[] = $row;
					}
				} 
					return $results;
			} else {
					//se nao tiver transacao retorna uma excecao
	 				throw new Exception('Na há transação ativa.');
			}
		}

		function delete(TCriteria $criteria){
			
			$sql = new TSqlDelete();
			$sql->setEntity($this->class);
			
			$sql->setCriteria($criteria);
			
			//obtem a transacao ativa
			if($conn = TTransaction::get()){
				//registra uma mensagem no log
				TTransaction::log($sql->getInstruction());
				//executa a instrucao de delete
				$result = $conn->exec($sql->getInstruction());
				return $result;
			}else{
				//senao hover transacao retorna uma excecao
				throw new Exception('Na há transação ativa.');
			}
		}
		
		/**
		 * metodo Count
		 * retorna a quantidade de objetos da base de dados
		 * que satisfazem um determinado criterio de selecao
		 * @param $criteria = objeto do tipo TCriteria
		 */
		function count(TCriteria $criteria){
			//instancia a instrucao de selecet
			$sql = new TSqlSelect();
			$sql->addColumn('count(*)');
			$sql->setEntity($this->class);
			//atribui o criterio passado como parametro
			$sql->setCriteria($criteria);
			
			//obtem a transacao ativa
		if($conn = TTransaction::get()){
				//registra uma mensagem no log
				TTransaction::log($sql->getInstruction());
				//executa a instrucao de delete
				$result = $conn->query($sql->getInstruction());
				if ($result){
					$row = $result->fetch();
				}
				//retorna o resultado da contagem
				return $row[0];
			}else{
				//senao hover transacao retorna uma excecao
				throw new Exception('Na há transação ativa.');
			}
		}
	}
?>