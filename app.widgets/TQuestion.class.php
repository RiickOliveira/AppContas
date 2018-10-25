<?php

	class TQuestion {

		function __construct($message, TAction $action_yes, TAction $action_no){

			$style = new TStyle('tquestion');
			$style->position ='absolute';
			$style->left = '30%';
			$style->top = '30%';
			$style->width = '300';
			$style->height = '150';
			$style->border_width = '1px';
			$style->color = 'black';
			$style->background = '#DDDDDD';
			$style->border = '4px solid #000000';
			$style->z_index = '10000000000000000';

			//CONVERTE OS NOMES DE METODOS EM URLS
			$url_yes = $action_yes->serialize();
			$url_no = $action_no->serialize();

			$style->show();

			$painel = new TElement('div');
			$painel->class = 'tquestion';

			$button1 = new TElement('input');
			$button1->type = 'button';
			$button1->value = 'Sim';
			$button1->onclick = "javascript:location='$url_yes'";

			$button2 = new TElement('input');
			$button2->type = 'button';
			$button2->value = 'Não';
			$button2->onclick = "javascript:location='$url_no'";

			$table = new TTable;
			$table->align = 'center';
			$table->cellspacing = 10;

			$row = $table->addRow();
			$row->addCell(new TImage("app.images/question.png"));
			$row->addCell($message);

			$row= $table->addRow();
			$row->addCell($button1);
			$row->addCell($button2);

			$painel->add($table);
			$painel->show();
		}
	}




?>