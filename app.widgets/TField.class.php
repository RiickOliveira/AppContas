<?php

	abstract class TField{

		protected $name,$size,$value,$editable,$tag;

		function __construct($name){

			self::setEditable(true);
			self::setName($name);
			self::setSize(200);

			//INSTANCIA UM ESTILO CSS CHAMADO TFIELD Q SERA UTILIZADO PELOS
			//CAMPOS DO FORMULARIO
			$style1 = new TStyle('tfield');
			$style1->border = 'solid';
			$style1->border_color = '#a0a0a0';
			$style1->border_width = '1px';
			$style1->z_index = '1';

			$style2 = new TStyle('tfield_disabled');
			$style2->border = 'solid';
			$style2->border_color = '#a0a0a0';
			$style2->border_width = '1px';
			$style2->background_color = '#e0e0e0';
			$style2->color = '#a0a0a0';

			$style1->show();
			$style2->show();

			//CRIA UM TAG HTML D TIPO <INPUT>
			$this->tag = new TElement('input');
			$this->tag->class = 'tfield'; //classe css
		}

		public function getName()
		{
		    return $this->name;
		}
		 
		public function setName($name)
		{
		    $this->name = $name;
		}

		public function getValue()
		{
		    return $this->value;
		}
		 
		public function setValue($value)
		{
		    $this->value = $value;
		}

		public function getEditable()
		{
		    return $this->editable;
		}
		 
		public function setEditable($editable)
		{
		    $this->editable = $editable;
		}

		//define uma propriedade para o campo
		function setProperty($name,$value){
			//define uma propriedade de $this->tag
			$this->tag->$name = $value;
		}

		//deifne a largura do widget
		function setSize($size){

			$this->size = $size;
			
		}
	}

?>