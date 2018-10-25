<?php 
	/*
	 * Classe TSqlInstruction 
	 * Esta classe prove metodos em comum entre todas as instrucoes
	 * SQL (INSERT,DELETE, e UPDATE)
	 */

	abstract class TSqlInstruction{
		protected $sql; //armazena a instrucao sql
		protected $criteria; //armazena o criterio
		
		/*
		 * metodo setEntity
		 * define o nome da entidade (tabela) manipulada pela instrucao sql
		 * @param $entity = tabela
		 */		
		final public function setEntity($entity){
			$this->entity = $entity;
		}
		
		/*
		 * metodo getEntity
		 * retorna o nome da entidade (tabela)
		 */
		final public function getEntity(){
			return $this->entity;
		}
		
		/*
		 * metodo setCriteria
		 * Define um criterio de selecao dos dados atraves da composicao de um objeto
		 * do tipo TCriteria, que oferece uma interface para definicao de criterios,
		 * @param $criteria = objeto do Tipo TCriteria
		 */
		public function setCriteria(TCriteria $criteria){
			$this->criteria = $criteria;
		}
		
		/*
		 * metodo getInstruction
		 * declarando-o como 'abstract' obrigo sa declaracao nas classes filhas
		 * uma vez que seu comportamento sera distinto em cada um deles, 'POLIMORFISMO' 
		 */
		abstract function getInstruction(); 
		
	}	
?>