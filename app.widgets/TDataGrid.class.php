<?php

	class TDataGrid extends TTable{

		private $columns,$actions,$rowcount;

		function __construct(){

			parent::__construct();
			$this->class = 'tdatagrid_table';

			$style1 = new TStyle('tdatagrid_table');
			$style1->border_collapse = 'separate';
			$style1->font_family = 'arial,verdana,sans-serif';
			$style1->font_size = '10pt';
			$style1->border_spacing = '0pt';

			$style2 = new TStyle('tdatagrid_col');
			$style2->font_size = '10pt';
			$style2->font_weight = 'bold';
			$style2->border_left = '1px solid white';
			$style2->border_top = '1px solid white';
			$style2->border_right = '1px solid grey';
			$style2->border_bottom = '1px solid grey';
			$style2->padding_top = '5px';
			$style2->padding_bottom = '5px';
			$style2->background_color = '#8888ec9e';
			
			/*padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;*/
		
			$style3 = new TStyle('tdatagrid_col_over');
			$style3->font_size = '10pt';
			$style3->font_weight = 'bold';
			$style3->border_left = '1px solid white';
			$style3->border_top = '2px solid green';
			$style3->border_right = '1px solid grey';
			$style3->border_bottom = '1px solid grey';
			$style3->padding_top = '0px';
			$style3->background_color = '#dcdcdc';
			$style3->cursor = 'pointer';

			$style1->show();
			$style2->show();
			$style3->show();
		}
		//adiciona uma coluna a listagem
		function addColumn(TDataGridColumn $object){

			$this->columns[] = $object;
		}

		//adiciona uma acao a listagem
		function addAction(TDataGridAction $object){

			$this->actions[] = $object;
		}

		//elimina todas as linhas de dados
		function clear(){
			//faz uma copia do cabecalho
			$copy = $this->children[0];
			//inicializa o vetor de linhas
			$this->children = array();
			//acrescenta novamente o cabecalho
			$this->children[] = $copy;
			//zera a contagem de linhas
			$this->rowcount = 0;
		}

		//cria a estrutura do grid com seu cabecalho]
		function createModel(){
			//adiciona uma linha a tabela
			$row = parent::addRow();
			//adiciona celulas para as acoes
			if ($this->actions){

				foreach ($this->actions as $action) {
					$celula = $row->addCell('');
					$celula->class = 'tdatagrid_col';
				}
			}
			//adiciona celula para as acoes
			if ($this->columns){
				//percorre as colunas das listagems
				foreach ($this->columns as $column) {
					//obtem as propriedades da coluna
					$name  = $column->getName();
					$label = $column->getLabel();
					$align = $column->getAlign();
					$width = $column->getWidth();
					//adiciona a celula com a coluna
					$celula = $row->addCell($label);
					$celula->class = 'tdatagrid_col';
					$celula->align = $align;
					$celula->width = $width;
					//verifica se a coluna tem uma acao
					if($column->getAction()){

						$url = $column->getAction();
						$celula->onmouseover = "this.className='tdatagrid_col_over';";
						$celula->onmouseout = "this.className='tdatagrid_col';";
						$celula->onclick = "document.location='$url'";
					}
				}
			}
		}

		//adiciona um objeto na grid
		function addItem($object){
			//cria um estilo com cor variavel
			$bgcolor = ($this->rowcount % 2) == 0 ? '#f0f0f0' : '#e0e0e0';
			//adiciona uma linha na data grid
			$row = parent::addRow();
			$row->bgcolor = $bgcolor;

			//verifica se a listagem possui acoes
			if ($this->actions){
				//percorre as acoes
				foreach($this->actions as $action){
					//obtem as propriedades das acoes
					$url = $action->serialize();
					$label = $action->getLabel();
					$image = $action->getImage();
					$field = $action->getField();
					//obtem o campo do objeto que sera passado adiante
					$key = $object->$field;

					//cria um link
					$link = new TElement('a');
					$link->href = "{$url}&key={$key}";

					//verifica se o link sera com imagem ou com texto
					if ($image){
						//adiciona  a imagem ao link
						$image = new TImage("app.images/$image");
						$link->add($image);
					}
					else {
						//adiciona o rotulo de texto ao link
						$link->add($label);
					}
					//adiciona a celula a linha
					$row->addCell($link);
				}
			}
			if ($this->columns){
				//percorre as colnas de datagrid
				foreach($this->columns as $column){
					//obtem as propriedades da coluna
					$name = $column->getName();
					$align = $column->getAlign();
					$width = $column->getWidth();
					$function = $column->getTransformer();
					$data = $object->$name;
					//verifica se ha a funcao para transfomras os dados
					if ($function){
						//aplica a funcao sobre os dados
						$data = call_user_func($function,$data);
					}
					//adiciona a celula na linha
					$celula = $row->addCell($data);
					$celula->align = $align;
					$celula->width = $width;
				}
			}
			//incrementa o contador de linhas
			$this->rowcount++;
		}
	}
?>