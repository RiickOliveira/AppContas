<?php
	
	class TElement {

		private $name;
		private $properties;
		protected $children;
		//CONSTRUTOR INSTANCIA UMA TAG HTML

		function __construct($name){
			//DEFINE O NOME DO ELEMENTO
			$this->name = $name;
		}

		function __set($name,$value){
			// armazena os valores atribuídos
        	// ao array properties
			$this->properties[$name] = $value;
		}
		/**
     	* método add()
     	* adiciona um elemento filho
     	* @param $child = objeto filho
     	*/
		function add($child){

			$this->children[] = $child;
		}

		//METODO OPEN EXIBE A TAG DE ABERTURA NA TELA
		private function open(){

			echo "<{$this->name}";
			if ($this->properties){
				foreach ($this->properties as $name=>$value) {
					echo " {$name}=\"{$value}\"";
				}
			} 
			echo '>';
		}

		//METODO SHOW EXIBE A TAG JUNTO COM SEU CONTEUDO
		function show(){

			$this->open();
			echo"\n";
			if ($this->children){
				foreach ($this->children as $child) {
					
					if (is_object($child)){
						$child->show();
					} else if ((is_string($child)) or (is_numeric($child))) {
						echo $child;
					}
				}
				$this->close();
			}
		}

		function close(){
			echo "</{$this->name}>\n";
		}

	}





?>