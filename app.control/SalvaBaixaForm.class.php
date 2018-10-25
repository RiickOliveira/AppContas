<?PHP

	//classe concluiVenda formulario de conclusao de venda
	class SalvaBaixaForm extends TPage{
		private $form;
			function __construct(){


			parent::__construct();
			//instancia umm formulatrio
			$this->form = new TForm('form_cadastro_despesa');
			//instancia uma tabela
			$table = new TTable;
			//adiciona a tabela ao formulario
			$this->form->add($table);
			//cria os campos do formulario
			$codigo = new TEntry('id');
			$pessoa = new TCombo('id_pessoa');
			$categoria = new TCombo('id_categoria');
			$vencimento = new TEntry('vencimento');
			$historico = new TEntry('historico');
			$valor = new TEntry('valor');
			$data_baixa = new TEntry('data_baixa');
			//define alguns atribuitos para o campo do formulario
			$codigo->setEditable(false);
			$codigo->setSize(50);
			$pessoa->setEditable(false);
			$categoria->setEditable(false);
			$vencimento->setEditable(false);
			$historico->setEditable(false);

			
			//$data_baixa->setEditable(false);
			

			//carrega os fabricantes do banco de dados
			TTransaction::open('my_appcontas');
			//instancia um repositorioo de fabricante
			$repository = new TRepository('Pessoa');
			//carrega todos os objetos
			$collection = $repository->load(new TCriteria);
			//adiciona objetos na tcombo
			$itens = array();
			foreach($collection ?? [] as $object){

				$itens[$object->id] = $object->nome;
			}
			$pessoa->addItens($itens);

			//instancia um repositorioo de fabricante
			$repositorio = new TRepository('Categoria');
			//carrega todos os objetos
			$collection2 = $repositorio->load(new TCriteria);
			//adiciona objetos na tcombo
			$itens2 = array();
			foreach($collection2 ?? [] as $object){

				$itens2[$object->id] = $object->descricao;
			}
			$categoria->addItens($itens2);
			TTransaction::close();

			
			$row = $table->addRow();
			$row->addCell(new TLabel('Código:'));
			$row->addCell($codigo);

			$row = $table->addRow();
			$row->addCell(new TLabel('Pessoa:'));
			$row->addCell($pessoa);

			$row = $table->addRow();
			$row->addCell(new TLabel('Categoria:'));
			$row->addCell($categoria);

			$row = $table->addRow();
			$row->addCell(new TLabel('Data Vencimento:'));
			$row->addCell($vencimento);

			$row = $table->addRow();
			$row->addCell(new TLabel('Historico:'));
			$row->addCell($historico);

			$row = $table->addRow();
			$row->addCell(new TLabel('Valor:'));
			$row->addCell($valor);

			$row = $table->addRow();
			$row->addCell(new TLabel('Data Baixa:'));
			$row->addCell($data_baixa);


			//cria um botao de acao do formulario
			$button1 = new TButton('');
			//define a acao do butao
			$button1->setAction(new TAction(array($this,'onSave')),'Salvar');

			//adiciona uma linha para acao do formulario
			$row = $table->addRow();
			$row->addCell('');
			$row->addCell($button1);

			//define quais os campos do formualrio
			$this->form->setFields(array($codigo,$pessoa,$categoria,$vencimento,$valor,$historico,$data_baixa,$button1));
			//adiciona o formulario a pagina
			parent::add($this->form);
		}
		function onSave(){

			try{
				//inicia a transacao com bd
				TTransaction::open('my_appcontas');
				//le dados do formulario e instancia um objeto clientRecord
				$receita = $this->form->getData('ReceitaDespesaRecord');
				//define o tipo da operacao (1=receita e 0=despesa)
				$receita->baixado = 1;
				//armazena o objeto no banco de dados
				$receita->store();

				//finaliza trnasacao
				TTransaction::close();
				new TMessage('checked','Dados armazenados com sucesso');
			
			}  catch(Exception $e) {
				new TMessage('error','ERRO' . $e->getMessage());
				TTransaction::rollback();
			}
		}
		function onEdit($param){

			try{
				if (isset($param['key']))
            {
                // inicia transação com o banco 'pg_livro'
                TTransaction::open('my_appcontas');

                // obtém o Cliente de acordo com o parâmetro
                $receita = new ReceitaDespesaRecord($param['key']);

                if($receita->baixado){
                	//new TMessage('error','Impossivel editar esta receita');
                	//header('location:home.php?class=Receita_DespesaList');
                	echo "<script language='javascript' type='text/javascript'>alert('RECEITA JA BAIXADA!');window.location.href='home.php?class=Receita_DespesaList';</script>";                		

                } else {
                	
                	// lança os dados do cliente no formulário
                	$this->form->setData($receita);
                	
                }                

                // finaliza a transação
                TTransaction::close();
            }
			} catch(Exception $e) {
				new TMessage('error','ERRO' . $e->getMessage());
				//desfaz alteracoes no banco
				TTransaction::rollback();
			}
		}
	}

?>