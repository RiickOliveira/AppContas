
<?php
class Categoria{
    private $descricao;
    private $nivel;
    private $subCategorias = array();    
    
    function __construct($descricao){        
        $this->descricao = $descricao;
        $this->nivel = 1;
    }
    
    function addCategoria($descricao){
        $categoria = new Categoria($descricao);
        array_push($this->subCategorias, $categoria);
        $categoria->setNivel(count($this->subCategorias));
        return $categoria;
    }   

    function setNivel($nivel){
        $this->nivel = $nivel;
    }
    
    function print($codigo){
        $codigo = $codigo . $this->nivel . '.';

        echo "<li>$codigo $this->descricao</li>"; 
            
        foreach ($this->subCategorias as $subCategoria) { 
            echo "<ul>";
            $subCategoria->print($codigo);
            echo "</ul>";     
        }             
    }
}

class CategoriaList{

    public $categorias = array();

    function addSubCategoria(Categoria $categoria){
        
        array_push($this->categorias, $categoria);
        $categoria->setNivel(count($this->categorias));
        
    }   

    function print(){

        foreach ($this->categorias as $categoria) {             
            
            $categoria->print('');

        }             
    }
    
}   

$despesas = new Categoria('Despesas');
$despesaFixa = $despesas->addCategoria('Despesas fixas');
$impostos = $despesaFixa->addCategoria('Impostos');
$impostos->addCategoria('ICMS');
$impostos->addCategoria('IPI');

$folhaPagamento = $despesaFixa->addCategoria('Folha de pagamento');
$folhaPagamento->addCategoria('Setor Desenvolvimento');

$despesaVariavel = $despesas->addCategoria("Despesas variáveis");
$comissoes = $despesaVariavel->addCategoria('Comissões');
$comissoes->addCategoria('Setor Desenvolvimento');
$comissoes->addCategoria('Setor Marketing');

$combustivel = $despesaVariavel->addCategoria("Combustível");
$combustivel->addCategoria('Toyota Etios');
$combustivel->addCategoria('Renault Duster');
$combustivel->addCategoria('Honda Civic');

$receitas = new Categoria('Receitas');
$receita = $receitas->addCategoria('Receitas sobre Vendas');
$receita->addCategoria('Receitas Fiscais');
$receita->addCategoria('Outras receitas');
$receita_finan = $receitas->addCategoria('Receitas Financeiras');
$receita_finan->addCategoria('Juros Obtidos');

$ativo_fixo = new Categoria('Ativo Fixo');
$imoveis = $ativo_fixo->addCategoria('Imóveis');

$listaDespesas = new CategoriaList();
$listaDespesas->addSubCategoria($despesas);
$listaDespesas->addSubCategoria($receitas);
$listaDespesas->addSubCategoria($ativo_fixo);


echo '
<html>
<head>
<style>
ul li { 
    list-style-type: none }
</style>
</head>

<body>
<ul>
';    

$listaDespesas->print();
 

echo '
</ul>
</body>
</html>'

?>