<?php
	/*
	 * RODRIGO OLIVEIRA 22/04/2009 - 17:06
	 * 
	 * classe TRecord
	 * esta classe prove metodos necessarios para persistir e recuperar objetos
	 * da base da dados (Active Record). 
	 * NOTA: o nome da classe que derivar desta deve conter o nome da tabela
	 * no banco de dados seguido da extensao 'Record' exemplo: AlunoRecord
	 */
	abstract class TRecord{
		protected $data; //array contendo os dados do objeto
		
		/*
		 * metodo construtor
		 * instancia um active record, se passado o id, ja carrega o objeto
		 * @param[$id] = ID do objeto
		 */
		public function __construct($id = NULL){
			if ($id){//se o id for informado
				//carrega o objeto correspondente
				$objeto = $this->load($id);
				if($objeto){
					$this->fromArray($objeto->toArray());
				}
			}
		}
		
		/*
		 * metodo __clone
		 * executado quando objeto for clonado
		 * limpa o ID para que seja gerado um novo ID para o clone
		 */
		public function __clone(){
			unset($this->id);
		}
		
		/*
		 * metodo __set()
		 * executado sempre que uma propriedade for atribuida
		 */
		public function __set($prop,$value){
			//verifica se existe metodo set_<propriedade>
			if(method_exists($this,'set_'.$prop)){
				//executa o metodo set_<propriedade>
				call_user_func(array($this,'set_'.$prop),$value);
			}else{
				if ($value === null){
					unset($this->data[$prop]);
				} else {
				//atribui o valor da propriedade
				$this->data[$prop] = $value;
				}
			}
 		}
 		
 		/*
 		 * metodo __get
 		 * executado sempres que uma propriedade for requirida
 		 */
 		public function __get($prop){
 			//verifica se existe o metodo get_<propriedade>
 			if (method_exists($this,'get_'.$prop)){
 				//executa o metodo get_<propriedade>
 				return call_user_func(array($this,'get_'.$prop));
 			}else{ 
 				if (isset($this->data[$prop]))
 				{
 					//retorna o valor da propriedade
 					return $this->data[$prop];
 				}
 				
 			}
 		}
 		
 		/*
 		 * metodo getEntity
 		 * retorna o nome da entidade(tabela) o nome das classes filhas devem 
 		 * conter inicialmente o nome da tabela referente seguido de 'Record'
 		 */
 		private function getEntity(){
 			//obtem o nome da classe
 			$classe = strtolower(get_class($this));
 			//retorna o nome da classe sem o 'Record'
 			return substr($classe,0,-6);
 		}
 		
 		/*
 		 * metodo from array
 		 * preenche os dados do objeto com um array
 		 */
 		public function fromArray($data){
 			$this->data = $data;
 		}
 		
 		/*
 		 * metodo toArray
 		 * retorna os dados do objeto como array
 		 */
 		public function toArray(){
 			return $this->data;
 		}
 		
 		/**
 		 * remove
 		 * Remove uma chave do array de data
 		 * @param $field - chave a ser removida
 		 * */
 		public function remove($field){
 			unset($this->data[$field]);
 		}
 		
 		/*
 		 * metodo store
 		 * armazena o objeto na base da dados e retorna o numero de linhas
 		 * afetadas pela instrucao sql
 		 */
 		public function store(){
 			//verifica se tem o ID ou se existe na base de dados
 			if(empty($this->data['id']) or (!$this->load($this->id))){
 				//incrementa o ID
 				$this->id = $this->getLast()+1;
 				//cria uma instrucao de insert
 				$sql = new TSqlInsert();
 				$sql->setEntity($this->getEntity());
 				//percorre os dados do objeto
 				foreach($this->data as $key=>$value){
 					//passa os dados do objeto para o SQL
 					$sql->setRowData($key,$this->$key);
 				}
 			}else{
 				//instancia a instrucao de update
 				$sql = new TSqlUpdate();
 				$sql->setEntity($this->getEntity());
 				//cria um criterio de selecao baseado no ID
 				$criteria = new TCriteria; 				
 				$criteria->add(new TFilter('id','=',$this->id));
 				$sql->setCriteria($criteria);
 				//percorre os dados do objeto
 				foreach($this->data as $key=>$value){
 					if($key !== 'id'){//o ID nao precisa ir no Update
 						//passa os dados do objeto para o sql
 						$sql->setRowData($key,$this->$key);
 					}
 				}
 			} 			
 			//obtem a transacao ativa
 			if($conn = TTransaction::get()){
 				//faz o log e executa o Sql
 				//TTransaction::log($sql->getInstruction());
 				$result = $conn->exec($sql->getInstruction());
 				//retorna o resultado
 				return $result;
 			}else{
 				//senao tiver transacao
 				throw new Exception('Na há transação ativa.');
 			}
 		}
 		
 		/*
 		 * metodo load
 		 * recupera e retorna um objeto da base de dados
 		 * atraves de seu ID instancia ele na memoria
 		 * @param $id = ID objeto
 		 */
 		public function load($id){
 			//instancia instrucao select
 			$sql = new TSqlSelect;
 			$sql->setEntity($this->getEntity());
 			$sql->addColumn('*');
 			
 			//cria o criterio de selecao baseado no ID
 			$criteria = new TCriteria; 						
 			$criteria->add(new TFilter('id','=',$id));
 			//define o criterio de selecao de dados
 			$sql->setCriteria($criteria);
 			//obtem a transacao ativa
 			if ($conn = TTransaction::get()){
 				//cria a mensagem de log e executa a consulta
 				//TTransaction::log($sql->getInstruction());
 				
 				$result = $conn->query($sql->getInstruction());
 				//se retornou algum dado
 				if($result){
 					//retorna os dados em forma de objeto
 					$objeto = $result->fetchObject(get_class($this));
 				} 				
 				return $objeto;
 			}else{
 				//se nao tiver transacao retorna uma excecao
 				throw new Exception('Na há transação ativa.');
 			} 
 		}
 		
 		/*
 		 * metodo delete 
 		 * exclui um objeto da base de dados atraves de seu id
 		 * @param $id = ID do obeto
 		 */
 		public function delete($id = NULL){
 			//o ID é o parametro ou a propriedade id
 			$id = $id ? $id : $this->id;
 			//instancia uma instrucao de delete
 			$sql = new TSqlDelete();
 			$sql->setEntity($this->getEntity());
 			
 			//cria o criterio de selecao de dados
 			$criteria = new TCriteria();
 			$criteria->add(new TFilter('id','=',$id));
 			//define o criterio de selecao
 			$sql->setCriteria($criteria);
 			
 			//obtem a transacao ativa
	 		if($conn = TTransaction::get()){
	 			//faz o log e executa o Sql
	 			TTransaction::log($sql->getInstruction());
	 			$result = $conn->exec($sql->getInstruction());
	 			//retorna o resultado
	 			return $result;
	 		}else{
	 			//se nao tiver transacao
	 			throw new Exception('Na há transação ativa.');
	 		}
 		}
 		
 		/*
 		 * metodo getLast
 		 * retorna o ultimo ID;
 		 */
 		private function getLast(){
 			//inicia a transacao
 			if ($conn = TTransaction::get()){
 				//instancia a instrucao de selct
 				$sql = new TSqlSelect(); 				
 				$sql->addColumn('max(id) as ID');
 				$sql->setEntity($this->getEntity());
 				//cria o log e executa a transacao
 				//TTransaction::log($sql->getInstruction());
 				$result = $conn->query($sql->getInstruction());
 				//retorna os dados do banco
 				$row = $result->fetch();
 				return $row[0];
 			}else{
 				//senao tiver transacao
	 			throw new Exception('Na há transação ativa.');
 			}
 		} 		
 		
	}
?>