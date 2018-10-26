<?php
	function formata_money($valor){
		return number_format($valor,2,',','.');
		}
	function conv_data_to_us($data){

			$dia = substr($data,0,2);
			$mes = substr($data,3,2);
			$ano = substr($data,6,4);
			return "{$ano}-{$mes}-{$dia}";
		}
		function conv_data_to_br($data){

			$ano = substr($data,0,4);
			$mes = substr($data,5,2);
			$dia = substr($data,8,4);
			return "{$dia}-{$mes}-{$ano}";
		}
	





	//classe para listar receitas e despesas
	class Receita_DespesaList extends Tpage{

		private $form,$datagrid,$loaded;

		function __construct(){

			parent::__construct();
			$this->form = new TForm('receita_despesa');

			$table = new TTable;
			$this->form->add($table);

			/*$nome = new TEntry('nome');
			
			$row = $table->addRow();
			$row->addCell(new Tlabel('Nome:'));
			$row->addCell($nome);

			$find_button = new TButton('busca');
			$find_button->setAction(new TAction(array($this,'onReload')),'Buscar');*/
			
			$button1 = new TButton('nova_despesa');
			$obj = new DespesaForm;
			$button1->setAction(new TAction(array($obj,'onEdit')),'Nova Despesa');

			$button2 = new TButton('nova_receita');
			$obj = new ReceitaForm;
			$button2->setAction(new TAction(array($obj,'onEdit')),'Nova Receita');

			$row = $table->addRow();
			$row->addCell($button1);
			$row->addCell($button2);
			//$row->addCell($find_button);

		$this->form->setFields(array($button1,$button2,/*$find_button*/));

			$this->datagrid = new TDataGrid;

			$codigo = new TDataGridColumn('id','Código','center',20);
			$pessoa = new TDataGridColumn('nome_pessoa','Pessoa','left',160);
			$categoria = new TDataGridColumn('nome_categoria','Categoria','left',150);
			$vencimento = new TDataGridColumn('vencimento','Data Vencimento','center',100);
			$valor = new TDataGridColumn('valor','Valor','left',50);
			$historico = new TDataGridColumn('historico','Historico','left',150);
			$receita = new TDataGridColumn('receita','Receita','center',40);
			$baixado = new TDataGridColumn('baixado','Baixado','center',40);
			$data_baixa = new TDataGridColumn('data_baixa','Data Baixa','center',150);

			$valor->setTransformer('formata_money');
			$vencimento->setTransformer('conv_data_to_br');
			$data_baixa->setTransformer('conv_data_to_br');

			$this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($pessoa);
			$this->datagrid->addColumn($categoria);
			$this->datagrid->addColumn($vencimento);
			$this->datagrid->addColumn($valor);
			$this->datagrid->addColumn($historico);
			$this->datagrid->addColumn($receita);
			$this->datagrid->addColumn($baixado);
			$this->datagrid->addColumn($data_baixa);


			$obj2 = new ReceitaDespesaForm;
			$action1 = new TDataGridAction(array($obj2,'onEdit'));
			$action1->setLabel('Editar');
			$action1->setImage('editar.png');
			$action1->setField('id');

			$action2 = new TDataGridAction(array($this,'onDelete'));
			$action2->setLabel('Deletar');
			$action2->setImage('deletebt.png');
			$action2->setField('id');

			$obj = new SalvaBaixaForm;
			$action3 = new TDataGridAction(array($obj,'onEdit'));
			$action3->setLabel('Baixa');
			$action3->setImage('baixa.png');
			$action3->setField('id');

			//adiciona as acoes a datagrid
			$this->datagrid->addAction($action1);
			$this->datagrid->addAction($action2);
			$this->datagrid->addAction($action3);

			//cria o modelo da datagrid montando sua estrutura
			$this->datagrid->createModel();

			//monta a pagina atraves de uma tabela
			$table = new TTable;
			//$table->width = '100%';
			$table->width = '730';
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
		//carrega a datagrid
		function onReload(){
			TTransaction::open('my_appcontas');

			$repositorio = new TRepository('ReceitaDespesa');

			$criterio = new TCriteria;
			$criterio->setProperty('order','id');

			$receitas_despesas = $repositorio->load($criterio);
			$this->datagrid->clear();
			if($receitas_despesas){
			
				$img = new TImage('./app.images/baixado.jpg');
				$img2 = new TImage('./app.images/aberto.jpg');
				$img3 = new TImage('./app.images/receita.png');
				$img4 = new TImage('./app.images/despesa.png');

				foreach ($receitas_despesas as $receita_despesa) {					
					
					if ($receita_despesa->baixado == true){
							$receita_despesa->baixado = $img;
						}	 else {
							$receita_despesa->baixado = $img2;
						}
					
					if ($receita_despesa->receita == true){
							$receita_despesa->receita = $img3;
						}	 else {
							$receita_despesa->receita = $img4;
						}
					//adiciona os itens na datagrid
					$this->datagrid->addItem($receita_despesa);					
				}
			}
			
			/*$repository = new TRepository('ReceitaDespesa');
			$criteria = new TCriteria;

			$dados = $this->form->getData('ReceitaDespesaRecord');
			//verifica se o usuario preencheu o formulario
			if($dados->nome){
				//filtra pelo nome do cliente
				$criteria->add(new TFilter('nome','like',"%{$dados->nome}%"));
			}

			//carrega os produtos q satisfazem o criterio
			$clientes = $repository->load($criteria);
			$this->datagrid->clear();
			if($clientes){

				foreach($clientes as $cliente){
					//adiciona o objeto na datagrid
					$this->datagrid->addItem($cliente);
				}
			}*/

			TTransaction::close();	

		}
		function onDelete($param){
			//obtem o parametro $key
			$key = $param['key'];
			//define duas acoes
			$action1 = new TAction(array($this,'delete'));
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
			$rec_des = new ReceitaDespesaRecord($key);
			//deleta o objeto do banco de dados
			$rec_des->delete();

			TTransaction::close();
			//exibe msg de sucesso
			new TMessage('checked','Registro excluido com sucesso');
		
			$this->onReload();
		}	

		function show(){
			// se a listagem ainda nao foi carregada
			if(!$this->loaded){

				$this->onReload();
			}
			parent::show();
		}
		
	}

?>