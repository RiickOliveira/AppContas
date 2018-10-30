<?php

    class Despesas{

        private $descricao;
        private $despesas_fixas = array();
        private $despesas_variaveis = array();

        function __construct($descricao){
            $this->descricao = $descricao;
        }

        
        function addDespesaFixa(Despesas $desp_fixas){

            array_push($this->despesas_fixas,$desp_fixas);

        }

        function addDespesaVariavel(Despesas $desp_variavel){

            array_push($this->despesas_variaveis,$desp_variavel);

        }

        function print($marginLeft){
            echo "$this->descricao<br>";                
            
            if (count($this->despesas_fixas) > 0) {
                echo "<br /> <p style='margin-left: $marginLeft'> ";
            }
            
            foreach ($this->despesas_fixas as $desp_fixas) {                    
                $marginLeft = $marginLeft + 20;    
                $desp_fixas->print($marginLeft);
            }

    }

}

$topico = new Despesas('Despesas');
$sub_topico = new Despesas('Despesas Fixas');
$sub_topico2 = new Despesas('Despesas Variaveis');

$tipo = new Despesas('Impostos');
$imposto1 = new Despesas('IPI');
$imposto2 = new Despesas('ICMS');

$tipo2 = new Despesas('Folha de Pagamento');
$setor = new Despesas('Setor Desenvolvimento');



$topico->addDespesaFixa($sub_topico);
$topico->addDespesaVariavel($sub_topico2);
$sub_topico->addDespesaFixa($tipo);

$tipo->addDespesaFixa($imposto1);
$tipo->addDespesaFixa($imposto2);

$topico->print(20);



?>