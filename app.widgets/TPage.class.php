<?PHP

	#CLASSE PARA CONTROLE DE FLUXO DE EXECUCAO
	class TPage extends TElement{

		function __construct(){
			//DEFINE O ELEMENTO QE IRA REPRESENTAR
			parent::__construct('html');
		}

		//EXIBE O CONTEUDO DA PAGInA
		function show(){

			$this->run();
			parent::show();
		}

		//EXECUTA DETERMINADO METODO DE ACORDO OS PARAMETROS RECEBIDOS
		function run(){

			if ($_GET){
				
				$class = isset($_GET['class']) ? $_GET['class'] : NULL;
            	$method = isset($_GET['method']) ? $_GET['method'] : NULL;

				if ($class){
					$object = $class == get_class($this) ? $this : new $class;
					if (method_exists($object, $method)){

						call_user_func(array($object,$method), $_GET);
					}
				} elseif(function_exists($method)){

					call_user_func($method,$_GET);
				}

			}
		}
	}

?>