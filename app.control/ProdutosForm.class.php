<?php
	//formulario de cadastro de produto

	class ProdutosForm extends TPage{

		private $form; //formulario
		

		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_clientes');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$codigo = new TEntry('id');
			$descricao = new TEntry('descricao');
			$estoque = new TEntry('estoque');
			$preco_custo = new TEntry('preco_custo');
			$preco_venda = new TEntry('preco_venda');
			$fabricante = new TCombo('id_fabricante');

			//carrega os fabricantes do banco de dados
			TTransaction::open('my_livro');
			//instancia um repositorioo de fabricante
			$repository = new TRepository('Fabricante');
			//carrega todos os objetos
			$collection = $repository->load(new TCriteria);
			//adiciona objetos na tcombo
			$itens = array();
			foreach($collection ?? [] as $object){

				$itens[$object->id] = $object->nome;
			}
			$fabricante->addItens($itens);
			TTransaction::close();

			// define alguns atributos para os campos do formulário
			$codigo->setEditable(FALSE);
			$codigo->setSize(100);
			$estoque->setSize(100);
			$preco_custo->setSize(100);
			$preco_venda->setSize(100);
			//adiciona uma linha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Código:'));
			$row->addCell($codigo); 

			$row = $table->addRow();
			$row->addCell(new TLabel('Descrição:'));
			$row->addCell($descricao); 

			$row = $table->addRow();
			$row->addCell(new TLabel('Estoque:'));
			$row->addCell($estoque); 

			$row = $table->addRow();
			$row->addCell(new TLabel('Preço Custo:'));
			$row->addCell($preco_custo); 

			$row = $table->addRow();
			$row->addCell(new TLabel('Preço Venda:'));
			$row->addCell($preco_venda); 

			$row = $table->addRow();
			$row->addCell(new TLabel('Fabricante:'));
			$row->addCell($fabricante); 

			//cria um botao de acao no formulario
			$button1 = new TButton('action1');
			//define as acoes do butao
			$button1->setAction(new TAction(array($this,'onSave')),'Salvar');
			// adiciona uma linha para a ação do formulário
	        $row=$table->addRow();
	        $row->addCell('');
	        $row->addCell($button1);

	        //define quais sao os campos do formulario
	        $this->form->setFields(array($codigo,$descricao,$estoque,$preco_custo,$preco_venda,$fabricante,$button1));

	        //adiciona o form na page
	        parent::add($this->form);
		}
		//edita os dados de um registro
		function onEdit($param){

			try{
				if (isset($param['key'])){
				
				TTransaction::open('my_livro');
				//obtem o prodtuo de acordo o paramtro
				$produto = new ProdutoRecord($param['key']);
				//lanca os dados do produto no formulario
				$this->form->setData($produto);

				TTransaction::close();
			}	
			} catch (Exception $e){
				new TMessage('error','ERRO'.$e->getMessage());

				TTransaction::rollback();
			}
		}
		//executado qunadno o usuario clicar no botao salvar
		function onSave(){

			try{
				TTransaction::open('my_livro');
				//le os dados do formulario e instancia um obj produtoRecord
				$produto = $this->form->getData('ProdutoRecord');
				//armazena o objeto no banco de dados
				$produto->store();

				TTransaction::close();
				//exibe mensagem de sucesso
				new TMessage('checked','Dados armazenados com sucesso');
			
			} 	
			catch (Exception $e)
			{
				new TMessage('error','ERRO'.$e->getMessage());

				TTransaction::rollback();
			}
		}
	}
?>