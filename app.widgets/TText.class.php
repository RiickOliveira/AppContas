<?PHP

	class TText extends TField {

		private $width,$height;

		function __construct($name){

			parent::__construct($name);
			//cria uma tag html do tipo textarea
			$this->tag = new TElement('textarea');
			$this->tag->class = 'tfield';
			//define a altura padrao da caixa de texto
			$this->height = 100;
		}

		function setSize($width){

			$this->size = $width;
			
		}

		function show(){

			$this->tag->name = $this->name;
			$this->tag->style = "width:{$this->size};height:{$this->height}";
			
			if (!parent::getEditable()){

				$this->tag->readonly = '1';	
				$this->tag->class = 'tfield_disabled'; //classe css
			}
			//adiciona conteudo a textarea
			$this->tag->add(htmlspecialchars($this->value));
			$this->tag->show();
		}
	}
?>