<?php  

	//formulario de cadastro de clientes
	class CategoriaForm extends TPage{

		private $form; //formulario

		//cria a pagina e o formulario de cadastro
		function __construct(){

			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_cadastro_categoria');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$codigo = new TEntry('id');
			$descricao = new TEntry('descricao');
			
			//define alguns atribuitos para o campo do formulario
			$codigo->setEditable(false);
			$codigo->setSize(100);
			$descricao->setSize(300);

			//adiciona uma linha para o campo codigo
			$row = $table->addRow();
			$row->addCell(new TLabel('Código:'));
			$row->addCell($codigo);

			//adiciona uma linha para o campo nome
			$row = $table->addRow();
			$row->addCell(new TLabel('Descrição:'));
			$row->addCell($descricao);

			//cria um botao de acao do formulario
			$button1 = new TButton('action1');
			//define a acao do butao
			$button1->setAction(new TAction(array($this,'onSave')),'Salvar');

			//adiciona uma linha para acao do formulario
			$row = $table->addRow();
			$row->addCell('');
			$row->addCell($button1);

			//define quais os campos do formualrio
			$this->form->setFields(array($codigo,$descricao,$button1));
			//adiciona o formulario a pagina
			parent::add($this->form);
		}
		//edita os dados de um registro
		function onEdit($param){

			try{
				if (isset($param['key']))
            {
                // inicia transação com o banco 'pg_livro'
                TTransaction::open('my_appcontas');

                // obtém o Cliente de acordo com o parâmetro
                $categoria = new CategoriaRecord($param['key']);

                // lança os dados do cliente no formulário
                $this->form->setData($categoria);

                // finaliza a transação
                TTransaction::close();
            }
			} catch(Exception $e) {
				new TMessage('error','ERRO' . $e->getMessage());
				//desfaz alteracoes no banco
				TTransaction::rollback();
			}
		}
		//executado quando o usuario clicar em salvar
		function onSave(){

			try{
				//inicia a transacao com bd
				TTransaction::open('my_appcontas');
				//le dados do formulario e instancia um objeto clientRecord
				$pessoa = $this->form->getData('CategoriaRecord');
				//armazena o objeto no banco de dados
				$pessoa->store();

				//finaliza trnasacao
				TTransaction::close();
				new TMessage('checked','Dados armazenados com sucesso');
			
			}  catch(Exception $e) {
				new TMessage('error','ERRO' . $e->getMessage());
				TTransaction::rollback();
			}
		}
	}
?>