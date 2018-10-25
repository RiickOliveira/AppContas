<?PHP

	class TPanel extends TElement{

		function __construct($width,$height){

			$painel_style = new TStyle('tpanel');
			$painel_style->position = 'relative';
			$painel_style->width = $width;
			$painel_style->height = $height;
			$painel_style->border = '2px solid';
			$painel_style->border_color = 'grey';
			$painel_style->background_color = '#f0f0f0';

			$painel_style->show();

			parent::__construct('div');
			$this->class = 'tpanel';
		}

		function put($widget,$col,$row){

			$camada = new TElement('div');
			$camada->style = "position:absolute; left:{$col}px; top:{$row}px;";
			$camada->add($widget);

			parent::add($camada);
		}
	} 
?>