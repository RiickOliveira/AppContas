<?php

	class TButton extends TField {

		private $action,$label,$formName;

		function setAction($action,$label){

			$this->action = $action;
			$this->label = $label;
		}

		function setFormName($name){

			$this->formName = $name;
		}

		function show(){

			$url = $this->action->serialize();

			$this->tag->name = $this->name;
			$this->tag->type = 'button';
			$this->tag->value = $this->label;
			
			if (!parent::getEditable()){

				$this->tag->disabled = '1';
				$this->tag->class = 'tfield_disabled'; //classe css
			}
			//define a acao do botao
			$this->tag->onclick = "document.{$this->formName}.action='{$url}';".
								  "document.{$this->formName}.submit()";
			//exibe o botao					  
			$this->tag->show();
		}
	}


?>