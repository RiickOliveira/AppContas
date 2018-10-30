<?php

class Categoria{

    private $descricao;
    private $subCategorias = array();    

    function __construct($descricao){
        $this->descricao = $descricao;
    }

    function addCategoria($descricao){
        $categoria = new Categoria($descricao);
        return $categoria;
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


$despesas = new Categoria('Despesas');
$despesaFixa = $despesas->addCategoria('Despesas fixas');
$impostos = $despesaFixa->addCategoria('Impostos');
$impostos->addCategoria('ICMS');
$impostos->addCategoria('IPI');


$despesaVariavel = $despesas->addCategoria('Despesas variáveis');


?>
