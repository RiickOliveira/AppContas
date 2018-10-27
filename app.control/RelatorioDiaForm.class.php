<?php

	//class relatorioForm relatorio de vendas por pedido
	class RelatorioDiaForm extends TPage{

		private $form;

		//cria a pagina e o formulario de parametros
		public function __construct(){

			parent::__construct();
			//instancia um formulario
			$this->form = new TForm('form_relat_vendas');

			//instancia uma tabela
			$table = new TTable;

			$this->form->add($table);

			//cria os campos do formulario
			$data_ini = new TEntry('data_ini');
			$data_fim = new TEntry('data_fim');
			//define os tamanhos
			$data_ini->setSize(150);
			$data_fim->setSize(150);

			//adiciona uma linha para a data inicial 
			$row = $table->addRow();
			$row->addCell(new TLabel('Data Inicial: '));
			$row->addCell($data_ini);

			$row = $table->addRow();
			$row->addCell(new TLabel('Data Final: '));
			$row->addCell($data_fim);

			//cria um botao de acao
			$gera_button = new TButton('');
			//define acao do botao
			$gera_button->setAction(new TAction(array($this,'onGera')),'Gerar Relatório');

			//adiciona linha para acao do foromulario
			$row = $table->addRow();
			$row->addCell($gera_button);

			//define campos do formulario
			$this->form->setFields(array($data_ini,$data_fim,$gera_button));

			//adiciona o form a pagina
			parent::add($this->form);
		}
		//gera o relatorio, baseado nos paramtros do formulario
		function onGera(){
			//obtem os dados do formulario
			$dados = $this->form->getData();
			//joga os dados de volta ao formulario
			$this->form->setData($dados);

			//le os campos do formulario, converte para o padrao americano
			$data_ini = $this->conv_data_to_us($dados->data_ini);
			$data_fim = $this->conv_data_to_us($dados->data_fim);
			
			//instancia uma nova tabela
			$table = new TTable;
			$table->border = 1;
			$table->width = '100%';
			$table->style = 'border-collapse:collapse';

			//adiciona uma linha para o cabecalho do relatorio
			$row = $table->addRow();
			$row->bgcolor = '#a0a0a0';
			//adiciona as celulas ao cabecalho
			$cell = $row->addCell('Data');
			$cell = $row->addCell('Historico');
			//$cell = $row->addCell('Pessoa');
			$cell = $row->addCell('Valor');
			$cell->align = 'center';

			try{
				//inicia a transacao com o db
				TTransaction::open('my_appcontas');

				//instancia um repositorio da classe vendaRecord
				$repositorio = new TRepository('ReceitaDespesa');
				//cria um criterio de selecao por intervalo das datas
				$criterio = new TCriteria;
				$criterio->add(new TFilter('data_baixa','>=', $data_ini));
				$criterio->add(new TFilter('data_baixa','<=',$data_fim));
				$criterio->setProperty('order','data_baixa');

				//le todas baixas q satisfazem o criterio
				$baixas = $repositorio->load($criterio);				
				
				//verifica se retornou algum objeto
				if ($baixas){					
                    
                    $despesa_geral = 0;
                    $receita_geral = 0;
					$total_geral = 0;												
                    $data = '';					
					$i = 1;
					$count = count($baixas);					

					foreach($baixas as $baixa){	
						
						
						/// Cabeçalho com o nome da pessoa
						if ($data <> $baixa->data_baixa) {						
							
							if ($data <> '') {
                                $row = $table->addRow();
                                $cell = $row->addCell('');
                                $cell = $row->addCell('<b>Saldo do Dia</b>');								
								//$cell = $row->addCell('');					
								$cell = $row->addCell('<b>'.number_format($saldo_dia,2,',','.').'</b>');
                                $cell->align = 'right';
                            }
							
							$data   = $baixa->data_baixa;							

                           
                            $saldo_dia = 0;
                            $receitas = 0;
                            $despesas = 0;
                            
                            $row = $table->addRow();
							$row->bgcolor = '#e0e0e0';
							//$cell = $row->addCell('');	
							$cell = $row->addCell('Data Baixa: ');
							$cell->colspan = 3;
							//$cell = $row->addCell('');		

						} 						

						$row = $table->addRow();
						//adiciona as celulas com os dados do item
						$cell = $row->addCell($this->conv_data_to_br($baixa->data_baixa));
                        if ($baixa->receita == 0){
                            $cell = $row->addCell('( - )'.$baixa->historico);
                            $despesas 	 += $baixa->valor;
                            $despesa_geral += $baixa->valor;

                        } else {
                            $cell = $row->addCell('( + )'.$baixa->historico);
                            $receitas 	 += $baixa->valor;
                            $receita_geral += $baixa->valor;	
                        }
                       
						$cell = $row->addCell(number_format($baixa->valor,2,',','.'));
						$cell->align = 'right';
						
						$saldo_dia 	 = $receitas - $despesas;          
                        											
                                              
						if ($i == $count) {
                            $row = $table->addRow();
							$cell = $row->addCell('');
							$cell = $row->addCell('<b>Saldo do dia</b>');
							//$cell = $row->addCell('');					
							$cell = $row->addCell('<b>'.number_format($saldo_dia,2,',','.').'</b>');
							$cell->align = 'right';													
						}

						$i++;										
					}									
						
				}
                    $total_geral = $receita_geral - $despesa_geral; 
					//adiciona uma linha para o total das vendas
                    $row2 = $table->addRow();
					$cell = $row2->addCell('.');
			        $row = $table->addRow();
                    $cell = $row->addCell('<b>Receitas </b>');
                    $cell = $row->addCell('');
                    $cell = $row->addCell('<b>'.number_format($receita_geral,2,',','.').'</b>');
					$cell->align = 'right';
                    
                    $row = $table->addRow();
                    $cell = $row->addCell('<b>Despesas </b>');
                    $cell = $row->addCell('');
                    $cell = $row->addCell('<b>'.number_format($despesa_geral,2,',','.').'</b>');
					$cell->align = 'right';
                    
                    $row = $table->addRow();
                    $cell = $row->addCell('<b>Saldo Geral</b>');
					$cell = $row->addCell('');
					$cell = $row->addCell('<b>'.number_format($total_geral,2,',','.').'</b>');
					$cell->align = 'right';		
								
				
				TTransaction::close();
				
			} catch (Exception $e){
				//exibe msg gerada pela excecao
				new TMessage('error',$e->getMessage());

				TTransaction::rollback();
			}
			//adiciona a table a pagina
			parent::add($table);
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
	}
?>