<?php

	//cadastro de fabricantes
	//contem o formulario e a listagem
	class FabricanteList extends TPage{

		private $form; //formulario de cadastro
		private $datagrid; //listagem
		private $loaded;

		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_fabricantes');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$codigo = new TEntry('id');
			$nome = new TEntry('nome');
			$site = new TEntry('site');
			//define os tamanhos dos campos
			$codigo->setEditable(false);
			$codigo->setSize(40);
			$site->setSize(200);
			//adiciona uma liha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Codigo'));
			$row->addCell($codigo);
			//adiciona uma liha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Nome'));
			$row->addCell($nome);
			//adiciona uma liha para o campo site
			$row = $table->addRow();
			$row->addCell(new TLabel('Site'));
			$row->addCell($site);
			
			$save_button = new TButton('save');
			//define a acao do botao
			$save_button->setAction(new TAction(array($this,'onSave')),'Salvar');
			//adiciona uma linha para a acao do formulario
			$row = $table->addRow();
			$row->addCell($save_button);
			//define quais os campos do formulario
			$this->form->setFields(array($codigo,$nome,$site,$save_button));

			//instancia objeto TDataGrid
			$this->datagrid = new TDataGrid;
			//instancia as colunas da datagrid
			$codigo = new TDataGridColumn('id','Código','center',50);
			$nome = new TDataGridColumn('nome','Nome','left',200);
			$site = new TDataGridColumn('site','Site','left',100);
			//adiciona as colunas a datagrid
			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($nome);
			$this->datagrid->addColumn($site);
			//instancia duas acoes da datrid
			$action1 = new TDataGridAction(array($this,'onEdit'));
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

 			//monta a pagina  atraves de uma tabela
 			$table = new TTable;
 			//cria uma linha para o formulario
 			$row = $table->addRow();
 			$row->addCell($this->form);
 			//cria uma linha para a datagrid
 			$row = $table->addRow();
 			$row->addCell($this->datagrid);
 			//adiciona a tabela a pagina
 			parent::add($table);
		}
		//carrega a Datagrid com os objetos do banco de dados
		function onReload(){
			//inicia a transacao com o banco
			TTransaction::open('my_livro');
			//instqancia um repositorio para a cidaed
			$repository = new TRepository('Fabricante');
			//criterio de selecao pelo 'id'
			$criteria = new TCriteria;
			$criteria->setProperty('order','id');
			//carrega objetos de acordo com o criterio
			$fabricantes = $repository->load($criteria);
			$this->datagrid->clear();
			if($fabricantes){
				//percorre os objetos retornados
				foreach($fabricantes as $fabricante){
					//adiciona o objeto na datagrid
					$this->datagrid->addItem($fabricante);
				}
			}
			//finaliza a transacao
			TTransaction::close();
			$this->loaded = true;
		}
		//executada quando o usario clicar no botao salvar do formulario
		function onSave(){
			//inicia a transacao com o banco
			TTransaction::open('my_livro');
			//obtem os dados no formulario em um objeto cidadeRecorD
			$fabricante = $this->form->getData('FabricanteRecord');
			//armazena o objeto
			$fabricante->store();

			//finaliza a transacao
			TTransaction::close();
			//exibe mensagem de sucesso
			new TMessage('info','Dados armazenados com sucesso');
			//recarrega listagem
			$this->onReload();
		}
		//executada quando o usario clicar no botao excluir da datagrid
		//pergunta se deseja confirmar exclusao de registro
		function onDelete($param){
			//obtem o paramtro $key
			$key = $param['key'];

			//define duas acoes
			$action1 = new TAction(array($this,'Delete'));
			$action2 = new TAction(array($this,'teste'));
			//define os parametros de cada acao
			$action1->setParameter('key',$key);
			$action2->setParameter('key',$key);
			//exibe um dialogo ao usuario
			new TQuestion ('Deseja realmente excluir o registro?',$action1,$action2);
		}
		//exclui um registro
		function delete($param){
			//obtem o parametro $key
			$key = $param['key'];

			TTransaction::open('my_livro');
			//instancia objeto cidadeRecord
			$fabricante = new FabricanteRecord($key);
			//deleta o objeto no banco de dados
			$fabricante->delete();

			TTransaction::close();
			//recarrega a datagrid
			$this->onReload();
			new TMessage('checked','Registro excluido com sucesso!');
		}
		//executada quando o usuario clicar no botao editar da datagrid
		function onEdit($param){
			//obtem o parametro $key
			$key = $param['key'];

			TTransaction::open('my_livro');
			//instancia objeto cidadeRecord
			$fabricante = new FabricanteRecord($key);
			//lanca os dados no formulario
			$this->form->setData($fabricante);

			TTransaction::close();
			$this->onReload();
		}
		//exibe a pagina
		function show(){
			//se a listagem ainda nao foi carregada
			if(!$this->loaded){

				$this->onReload();
			}
			parent::show();
		}
	}
?>
