<?php
    
    class Pessoa {
        
        private $nome;
        private $filhos = array();

        function __construct($nome){
            $this->nome = $nome;
        }

        function addFilho(Pessoa $filho){
            
            array_push($this->filhos,$filho);           
            
        }
        
        function print($marginLeft){
                echo "Nome: $this->nome ";                
                
                if (count($this->filhos) > 0) {
                    echo "<br /> <p style='margin-left: $marginLeft'>Filhos: <br />";
                }
                
                foreach ($this->filhos as $filho) {                    
                    $marginLeft = $marginLeft + 20;    
                    $filho->print($marginLeft);
                }
        }

    }



    $bisavo = new Pessoa('Jose');	
    $avo = new Pessoa('Manoel');
    $pai = new Pessoa('Dera');
    $filho = new Pessoa('Danilo');
    $neto = new Pessoa('Hadassa');
   
    
    $bisavo->addFilho($avo);
    $avo->addFIlho($pai);
    $pai->addFilho($filho);
    $filho->addFilho($neto);

    $bisavo->print(0);

?>