<?php

	//listagem de produtos
	class ProdutosList extends TPage{

		private $form; //formulario de buscas
		private $datagrid; //listagem
		private $loaded;

		//cria a pagina, o formulario de buscas e a listagem
		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_busca_produtos');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$descricao = new TEntry('descricao');

			//adiciona uma linha para o campo descricao
			$row = $table->addRow();
			$row->addCell(new Tlabel('Descrição:'));
			$row->addCell($descricao);

			//cria dois botoes de acao para o formulario
			$find_button = new TButton('busca');
			$new_button = new TButton('cadastrar');
			//define as acoes do botao
			$find_button->setAction(new TAction(array($this,'onReload')),'Buscar');
			$obj = new ProdutosForm;
			$new_button->setAction(new TAction(array($obj,'onEdit')),'Cadastrar');
			//adiciona linhas para as acoes do formulario
			$row = $table->addRow();
			$row->addCell($find_button);
			$row->addCell($new_button);
			//define quais sao os campos do formulario
			$this->form->setFields(array($descricao,$find_button,$new_button));
			
			//instancia p objeto Datagrid
			$this->datagrid = new TDataGrid;
			//instancia as colunas da datagrid
			$codigo = new TDataGridColumn('id','Codigo','center',50);
			$descricao = new TDataGridColumn('descricao','Descrição','left',270);
			$fabrica = new TDataGridColumn('nome_fabricante','Fabricante','left',80);
			$estoque = new TDataGridColumn('estoque','Estoque','right',40);
			$preco = new TDataGridColumn('preco_venda','Venda','right',40);

			//adiciona as colunas a datagrid
			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($descricao);
			$this->datagrid->addColumn($fabrica);
			$this->datagrid->addColumn($estoque);
			$this->datagrid->addColumn($preco);

			//instancia duas acoes da datagrid
			$obj = new ProdutosForm;
			$action1 = new TDataGridAction(array($obj,'onEdit'));
			$action1->setLabel('Editar');
			$action1->setImage('editar.png');
			$action1->setField('id');
			
			$action2 = new TDataGridAction(array($this,'onDelete'));
			$action2->setLabel('Deletar');
			$action2->setImage('ico_delete.png');
			$action2->setField('id');		
			//adiciona as acoes a datagrid
			$this->datagrid->addAction($action1);
			$this->datagrid->addAction($action2);

			//cria o modelo da datagrid montando sua estrutura
			$this->datagrid->createModel();

			//monta a pagina atraves de uma tabela
			$table = new TTable;
			$table->width = '87%';
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

			TTransaction::open('my_livro');

			$repository = new TRepository('Produto');

			//cria um criterio de selecao de dados
			$criteria = new TCriteria;
			//ordena pelo campo id
			$criteria->setProperty('order','id');
			//obtem os dados do formulario de buscas
			$dados = $this->form->getData('ProdutoRecord');
			//verifica se o usuario preencheu o formulario
			if ($dados->descricao){
				//filtra pela descricao do produto
				$criteria->add(new TFilter('descricao','like',"%{$dados->descricao}%"));
			}
			//carrega os produtos q satisfazem o criterio
			$produtos = $repository->load($criteria);
			$this->datagrid->clear();
			if ($produtos){

				foreach($produtos as $produto){
					//adiciona o objeto na datagrid
					$this->datagrid->addItem($produto);
				}
			}
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

			TTransaction::open('my_livro');
			//instancia objeto ClienteRecord
			$produto = new ProdutoRecord($key);
			//deleta o objeto do banco de dados
			$produto->delete();

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