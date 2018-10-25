<?php
	//ENCAPSULA UMA ACAO
	class TAction{

		private $action;
		private $param;

		//INSTANCIA UMA NOVA ACAO (@PARAM = METODO A SER EXECUTADO)
	function __construct($action){

		$this->action = $action;
	}

	/*ACRESCENTA UM PARAMETRO AO METODO A SER EXECUTADO
	*@param $param = nome do parametro
	*@param $value = valor do parametro
	*/
	function setParameter($param,$value){
		$this->param[$param] = $value;
	}

	//TRANSFORMA A ACAO EM UMA STRING URL
		function serialize(){

			if(is_array($this->action)){
				//OBTEM O NOME DA CLASSE
				$url['class'] = get_class($this->action[0]);
				//OBTEM O NOME DO METODO
				$url['method'] = $this->action[1];
			
			} elseif (is_string($this->action)) {
				
				$url['method'] = $this->action;
			}

			//VFERIFICA SE HA PARAMETROS
			if ($this->param){

				$url = array_merge($url,$this->param);
			}

			return '?' . http_build_query($url);
		}

} 





?>