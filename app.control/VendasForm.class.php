<?php

	//exibe um valor com as casas decimais
	function formata_money($valor){
		return number_format($valor,2,',','.');
	}

	//classe vendasForm formulario de vendas
	class VendasForm extends TPage{

		private $form;  //formulario de novo item
		private $datagrid;  //listagem de itens
		private $loaded;
		//cria a pagina e o formulario de cadastro
		function __construct(){

			parent::__construct();
			//instancia nova sessao
			if(!isset($_SESSION)) 
		    { 
		        new TSession; 
		    } 
			//instancia um formulario
			$this->form = new TForm('form_vendas');

			//instancia uma tabela
			$table = new TTable;

			//adiciona a tabela ao formulario
			$this->form->add($table);

			//cria os campos do formulario
			$codigo = new TEntry('id_produto');
			$quantidade = new TEntry('quantidade');

			//define os tamanhos
			$codigo->setSize(100);

			//adiciona uma linha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Codigo'));
			$row->addCell($codigo);
			
			//adiciona uma linha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Quantidade'));
			$row->addCell($quantidade);

			//cria dois botoes de acao paraq o formualrio
			$save_button = new TButton('save');
			$fim_button = new TButton('fim');

			//define as acoees do botao
			$save_button->setAction(new TAction(array($this,'onAdiciona')),'Adicionar');
			$fim_button->setAction(new TAction(array($this,'onFinal')),'Finalizar');

			//adiciona uma linha para as acoes do formulario
			$row = $table->addRow();
			$row->addCell($save_button);
			$row->addCell($fim_button);

			//define os campos do formulario
			$this->form->setFields(array($codigo,$quantidade,$save_button,$fim_button));

			//instancia objeto datagrid
			$this->datagrid = new TDataGrid;

			//instancia as colinas da datagrid
			$codigo = new TDataGridColumn('id_produto','Codigo','center',50);
			$descricao = new TDataGridColumn('descricao','Descrição','left',200);
			$quantidade = new TDataGridColumn('quantidade','Quantidade','right',40);
			$preco = new TDataGridColumn('preco_venda','Preço','right',70);

			//define um transformador para a coluna preço
			$preco->setTransformer('formata_money');

			//adiciona as colunas a datagrid
			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($descricao);
			$this->datagrid->addColumn($quantidade);
			$this->datagrid->addColumn($preco);

			//cria uma acao para a datagrid
			$action = new TDataGridAction(array($this,'onDelete'));
			$action->setLabel('Deletar');
			$action->setImage('ico_delete.png');
			$action->setField('id_produto');

			//adiciona a acao a datagrid
			$this->datagrid->addAction($action);

			//cria o modelo da datagrid, montando sua estrutura
			$this->datagrid->createModel();

			//monta a pagina atraves de uma tabela
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
		//executada quadno o usuario clicar no botao salvar do formulario
		function onAdiciona(){
			//obtem os dados do formulario
			$item = $this->form->getData('ItemRecord');
			//le variavel $list da secao
			$list = TSession::getValue('list');
			//acrescenta produto na variavel $list
			$list[$item->id_produto] = $item;
			//grava variavel $list de volta  a secao
			TSession::setValue('list',$list);
			//recarrega a listagem
			$this->onReload();
		}
		//executada quando o usuario clicar no botao excluir da datagrid
		function onDelete($param){
			//le variavel $list da secao
			$list = TSession::getValue('list');
			//exclui a posicao que armazena o produto de codigo $key
			unset($list[$param['key']]);
			//grava variavel $list de volta a secao
			TSession::setValue('list',$list);
			//recarrega a listagem
			$this->onReload();
		}
		//carrega a datagrid com os objetos
		function onReload(){
			//obtem a variavel de secao $list
			$list = TSession::getValue('list');
			//limpa a grid
			$this->datagrid->clear();
			if ($list){
				//inicia a transacao com db
				TTransaction::open('my_livro');
				//percorre o array $list
				foreach($list as $item){
					//adciona cada objeto $item na datagrid
					$this->datagrid->addItem($item);
				}
				//fecha a transacao
				TTransaction::close();
			}
			$this->loaded = true;
		}
		//executada quando o usuario finalizaar a venda
		function onFinal(){
			
			//instancia umma nova janela
			$janela = new TWindow('Conclui Venda');
			$janela->setPosition(520,200);
			$janela->setSize(190,180);

			//le a variavel $list da secao
			$list = TSession::getValue('list');

			TTransaction::open('my_livro');
			$total = 0;
			foreach ($list as $item) {
				//soma o total de produtos vendidos
				$total += $item->preco_venda * $item->quantidade;
			}
			TTransaction::close();

			//istancia um formulario de conclusao de venda
			$form = new ConcluiVendaForm;
			//define a acao do botrao nesse formulario
			$form->button->setAction(new TAction(array($this,'onGravaVenda')),'Salvar');
			//preenche o formulario com o valor_total
			$dados = new VendaRecord;
			$dados->valor_total = $total;
			$form->setData($dados);

			//adiciona o formulario a janela
			$janela->add($form);
			$janela->show();
		}
		//executada qunado o usuario finalizar a venda
		function onGravaVenda(){
			//obtem os dados do formulario de conclusao de venda
			$form = new ConcluiVendaForm;
			$dados = $form->getData();

			TTransaction::open('my_livro');
			//instancia novo objeto VendaRecor
			$venda = new VendaRecord;
			
			//define os atributos a serem cortados
			$venda->id_cliente = $dados->id_cliente;
			$venda->data_venda = date('Y-m-d');
			$venda->desconto = $dados->desconto;
			$venda->valor_total = $dados->valor_total;
			$venda->valor_pago = $dados->valor_pago;
			//le a variavel $List da secao
			$itens = TSession::getValue('list');
			if ($itens){

				foreach($itens as $item){
					//adiciona o item na venda
					$venda->addItem($item);
				}
			}
		
			//armazena venda no banco de dados
			$venda->store();
			TTransaction::close();

			//limpa lista de itens da secao
			TSession::setValue('list',array());

			//exibe mensagem de sucesso
			new TMessage('checked','Venda registrada com sucesso');

			//recarrega lista de itens
			$this->onReload();
		}
		function abaixaEstoque(){

		}
		//executada quando o usuario clicar no botao excluir
		function show(){
			if(!$this->loaded){

				$this->onReload();
			}
			parent::show();
		}
	} 
?>