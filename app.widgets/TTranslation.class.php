<?php

	class TTranslation {

		private static $instance; //instancia de TTranslation
		private $lang; //linguagem de destino
		
		//instancia um objeto TTranslation
		function __construct(){

			$this->messages['en'][] = 'Function';
			$this->messages['en'][] = 'Table';
			$this->messages['en'][] = 'Tool';

			$this->messages['pt'][] = 'Função';
			$this->messages['pt'][] = 'Tabela';
			$this->messages['pt'][] = 'Ferramenta';

			$this->messages['it'][] = 'Funzione';
			$this->messages['it'][] = 'Tabelle';
			$this->messages['it'][] = 'Strumento';
		}
		//retorna a unica instancia de ttranslation
		public static function getInstance(){
			//se nao existe instancia ainda
			if (empty(self::$instance)){
				//instancia um objeto
				self::$instance = new TTranslation;
			}
			//retorna a instancia
			return self::$instance;
		}
		//define a linguagem a ser utilizada
		public static function setLanguage($lang){

			$instance = self::getInstance();
			$instance->lang = $lang;
		} 
		//retorna a linguagem atual
		public static function getLanguage(){

			$instance = self::getInstance();
			return $instance->lang;
		}
		//traduz uma palavra para a linguagem definida
		public static function Translate($word){
			//obtem a instancia atual
			$instance = self::getInstance();
			//busca o indide numerico da palavra dentro so vetor
			$key = array_search($word, $instance->messages['en']);
			//obtem a linguagem para traducao
			$language = self::getLanguage();
			//retorna  a palavra traduzida
			//vetor indexado pela linguagem e pela chave
			return $instance->messages[$language][$key];
		}
	}

		//fachada para o metodo transalte da classe TTRanslatio
		function _t($word){

			return TTranslation::Translate($word);
		}
?>