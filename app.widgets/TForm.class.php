<?php

	class TForm {

		protected $fields;#array de objetos contidos pelo form
		protected $name;#nome do formulario

		function __construct($name = 'my_form'){

			$this->setName($name);
		}

		function setName($name){

			$this->name = $name;
		}

		//DEFINNE SE O FORMULARIO PODE SER EDITADO
		function setEditable($bool){

			if ($this->fields){

				foreach ($this->fields as $object) {
					
					$object->setEditable($bool);
				}
			}
		}

		//DEFINE QUAIS SAO OS CAMPOS D FORMULARIO
		function setFields($fields){

			foreach ($fields as $field) {
				
				if ($field instanceof TField){

					$name = $field->getName();
					$this->fields[$name] = $field;

					if ($field instanceof TButton){

						$field->setFormName($this->name);
					}
				}
			}
		}

		//RETORNA UM CAMPO DO FORMULARIO POR SEU NOME
		function getField($name){

			return $this->fields[$name];
		}

		//ATRIBUI DADOS AOS CAMPOS DO FORMULARIO
		function setData($object){

			foreach ($this->fields as $name => $field) {
					
				if ($name){ //LABELS NAO POSSUEM NOME

					$field->setValue($object->$name);
				} 
			}
		}

		//RETORNA OS DADOS DO FORMULARIO EME FORMA DE OBJETO
		function getData($class = 'StdClass'){

			$object = new $class;
			foreach ($_POST as $key => $val) {
				
				if (get_class($this->fields[$key]) == 'TCombo'){

					if ($val !== '0'){

						$object->$key = $val;
					}
				} else {

					$object->$key = $val;
				}
			}

			foreach ($_FILES as $key => $content) {
				
				$object->$key = $content['tmp_name'];
			}
		
			return $object;
		}

		//ADICIONA UM OBJETO AO FORMULARIO
		function add($object){

			$this->child = $object;
		}

		//EXIBE O FORMULARIO NA TELA
		function show(){

			$tag = new TElement('form');
			$tag->name = $this->name;
			$tag->method = 'post';
			$tag->add($this->child);
			$tag->show();
		}
	}

?>