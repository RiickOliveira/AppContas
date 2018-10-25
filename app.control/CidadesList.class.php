<?php

	//cadastro de cidades: contem o formulatio e a listagem
	class CidadesList extends TPage{

		private $form; //formulario de cadastro
		private $datagrid; //listagem
		private $loaded;

		//cria a pagina, o formulario e a listagem
		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_cidades');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$codigo = new TEntry('id');
			$descricao = new TEntry('nome');
			$estado = new TCombo('estado');
			//cria um vetor com as opcoes do combo
			$itens = array();
			$itens['RS'] = 'Rio Grande do Sul';
			$itens['SP'] = 'São Paulo';
			$itens['MG'] = 'Minas Gerais';
			$itens['PR'] = 'Paraná';
			$itens['BA'] = 'Bahia';
			$itens['ES'] = 'Espirito Santo';

			//adiciona as opcoes na combo
			$codigo->setEditable(false);
			$estado->addItens($itens);
			//define os tamanhos dos campos
			$codigo->setSize(40);
			$estado->setSize(200);
			//adiciona uma linha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Codigo:'));
			$row->addCell($codigo);
			//adiciona uma linha para o campo descricao
			$row = $table->addRow();
			$row->addCell(new TLabel('Cidade:'));
			$row->addCell($descricao);
			//adiciona uma linha para o campo estado
			$row = $table->addRow();
			$row->addCell(new TLabel('Estado:'));
			$row->addCell($estado);
			//cria um botao de acao salvar
			$save_button = new TButton('save');
			//define a acao do botao
			$save_button->setAction(new TAction(array($this,'onSave')),'Salvar');
			//adiciona uma linha para a acao do formulario
			$row = $table->addRow();
			$row->addCell($save_button);
			//define quais os campos do formulario
			$this->form->setFields(array($codigo,$descricao,$estado,$save_button));

			//instancia objeto TDataGrid
			$this->datagrid = new TDataGrid;
			//instancia as colunas da datagrid
			$codigo = new TDataGridColumn('id','Código','center',50);
			$nome = new TDataGridColumn('nome','Nome','left',200);
			$estado = new TDataGridColumn('estado','Estado','left',40);
			//adiciona as colunas a datagrid
			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($nome);
			$this->datagrid->addColumn($estado);
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
			$repository = new TRepository('Cidade');
			//criterio de selecao pelo 'id'
			$criteria = new TCriteria;
			$criteria->setProperty('order','id');
			//carrega objetos de acordo com o criterio
			$cidades = $repository->load($criteria);
			$this->datagrid->clear();
			if($cidades){
				//percorre os objetos retornados
				foreach($cidades as $cidade){
					//adiciona o objeto na datagrid
					$this->datagrid->addItem($cidade);
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
			$cidade = $this->form->getData('CidadeRecord');
			//armazena o objeto
			$cidade->store();

			//finaliza a transacao
			TTransaction::close();
			//exibe mensagem de sucesso
			new TMessage('checked','Dados armazenados com sucesso');
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
			$cidade = new CidadeRecord($key);
			//deleta o objeto no banco de dados
			$cidade->delete();

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
			$cidade = new CidadeRecord($key);
			//lanca os dados no formulario
			$this->form->setData($cidade);

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