<?php

	class TStyle{

		private $name;
		private $properties;
		static private $loaded;

		function __construct($name){

			$this->name = $name;
		}

		function __set($name,$value){
			//SUBSTITUI O _ POR - NO NOME DA PROPRIEDADE
			$name = str_replace('_', '-',$name);
			//ARMAZENA OS VALORES ATRIBUIDOS AO ARRAY PROPERTIES
			$this->properties[$name] = $value;
		}

		function show(){


			if (!isset(self::$loaded[$this->name]) ){

				echo "<style type='text/css' media='screen'>\n";

				echo ".{$this->name}\n";
				echo "{\n";

				if ($this->properties){

					foreach ($this->properties as $name => $value) {
						
						echo "\t {$name}: {$value};\n";
					}
				}

				echo "}\n";
				echo "</style>\n";
				//MARCA O ESTILO COMO JA CARREGADO
				self::$loaded[$this->name] = true;
			}
		}
	}
?>