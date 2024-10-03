<?php
require_once("../classes/Database.class.php");
require_once("../classes/Circulo.class.php");
require_once("../classes/UnidadeMedida.class.php");

$conexao = new PDO(DSN, USUARIO, SENHA);


$idCirculo =  isset($_GET['idCirculo']) ? $_GET['idCirculo'] : 0;
$msg =  isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($idCirculo > 0) {
    $forma = Circulo::listar(1, $idCirculo)[0];
}

// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idCirculo =  isset($_POST['idCirculo']) ? $_POST['idCirculo'] : 0;
    $diametro =  isset($_POST['diametro']) ? $_POST['diametro'] : 0;
    $cor =  isset($_POST['cor']) ? $_POST['cor'] : 0;
    $unidade =  isset($_POST['UnidadeMedida']) ? $_POST['UnidadeMedida'] : 0;
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : 0;



    try {
        $Unids = UnidadeMedida::listar(1,$unidade)[0];
        $circulo = new Circulo($idCirculo, $diametro, $cor, $Unids);
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
        echo "TAMANHO:$ladoTamanho<br>COR:$cor<br>UNIDADE:$UnidadeMedida";
    }
    $resultado = "";

    

    switch ($acao) {
        case "salvar":
            $resultado = $circulo->incluir();
            break;
        case "alterar":
            $resultado = $circulo->alterar();
            break;
        case "excluir":
            $resultado = $circulo->excluir();
            break;
    }

    if ($resultado)
        header('location: index.php?MSG=Dados inseridos/Alterados com sucesso!');
    else
        header('location: index.php?MSG=Erro ao inserir/alterar registro');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Circulo::listar($tipo, $busca);
}
