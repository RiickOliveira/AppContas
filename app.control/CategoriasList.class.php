<?php

	//listagem de clientes
	class CategoriasList extends TPage{

		private $form; //formulario de buscas
		private $datagrid; //listagem
		private $loaded;

		//cria a pagina, o formulario de buscas e a listagem
		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			
			$new_button = new TButton('cadastrar');
		
			$obj = new CategoriaForm;
			$new_button->setAction(new TAction(array($obj,'onEdit')),'Nova Categoria');

			//adiciona linhas para as acoes do formulario
			$row = $table->addRow();
			$row->addCell($new_button);

			//define quais sao os campos do formulario
			$this->form->setFields(array($new_button));

			//instancia p objeto Datagrid
			$this->datagrid = new TDataGrid;
			//instancia as colunas da datagrid
			$codigo = new TDataGridColumn('id','Codigo','center',50);
			$descricao = new TDataGridColumn('descricao','Descrição','left',180);
			
			
			//adciona as colunas a datagrid
			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($descricao);
			
			//instancia duas acoes da datagrid
			//$obj = new ClientesForm;
			$action1 = new TDataGridAction(array($obj,'onEdit'));
			$action1->setLabel('Editar');
			$action1->setImage('editar.png');
			$action1->setField('id');

			$action2 = new TDataGridAction(array($this,'onDelete'));
			$action2->setLabel('Deletar');
			$action2->setImage('deletebt.png');
			$action2->setField('id');

			//adiciona as acoes a datagrid
			$this->datagrid->addAction($action1);
			$this->datagrid->addAction($action2);

			//cria o modelo da datagrid montando sua estrutura
			$this->datagrid->createModel();

			//monta a pagina atraves de uma tabela
			$table = new TTable;
			$table->width = '87%';
			//$table->height = '297px';
    
			//cria uma linha para o formulatrio
			$row = $table->addRow();
			$row->addCell($this->form);
			//cria uma linha para a datagrid
			$row = $table->addRow();
			$row->addCell($this->datagrid);
			//adiciona a tabela a pagina
			parent::add($table);
		}
		//carrega a datagrid com os objetos do banco de dados
		function onReload(){
			//inicia a trnasacao
			TTransaction::open('my_appcontas');
			//instancia um repositorio para cliente
			$repository = new TRepository('Categoria');
			//cria um criterio de selecao de dados
			$criteria = new TCriteria;
			//ordena pelo campo id
			$criteria->setProperty('order','id');

			//carrega os produtos q satisfazem o criterio
			$categorias = $repository->load($criteria);
			$this->datagrid->clear();
			if($categorias){

				foreach($categorias as $categoria){
					//adiciona o objeto na datagrid
					$this->datagrid->addItem($categoria);
				}
			}
			//finaliza a transaçao
			TTransaction::close();
			$this->loaded = true;
		}
		//qunado o usuario clica em excluir, abre confirmacao
		// da exclusao do registro
		function onDelete($param){
			//obtem o parametro $key
			$key = $param['key'];
			//define duas acoes
			$action1 = new TAction(array($this,'Delete'));
			$action2 = new TAction(array($this,'teste'));

			//define os parametros da cada acçao
			$action1->setParameter('key',$key);
			$action2->setParameter('key',$key);
			//exibe dialogo ao usuario
			new TQuestion('Deseja realmente excluir o registro?',$action1,$action2);
		}
		//exclui o registro apos a confirmcao do usuario
		function delete($param){
			//obtem o parametro $key
			$key = $param['key'];

			TTransaction::open('my_appcontas');
			//instancia objeto PessoaRecord
			$categoria = new CategoriaRecord($key);
			//deleta o objeto do banco de dados
			$categoria->delete();

			TTransaction::close();
			//recarrega a datagrid
			$this->onReload();
			//exibe msg de sucesso
			new TMessage('checked','Registro excluido com sucesso');
		}
		//executa quando o usuario clicar em excluir
		function show(){
			// se a listagem ainda nao foi carregada
			if(!$this->loaded){

				$this->onReload();
			}
			parent::show();
		}
	}
?>