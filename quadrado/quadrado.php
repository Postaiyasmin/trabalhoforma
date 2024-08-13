<?php
require_once("../classes/Database.class.php");
require_once("../classes/Quadrado.class.php");
require_once("../classes/UnidadeMedida.class.php");

$conexao = new PDO(DSN, USUARIO, SENHA);


$idQuadrado =  isset($_GET['idQuadrado']) ? $_GET['idQuadrado'] : 0;
$msg =  isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($idQuadrado > 0) {
    $forma = Quadrado::listar(1, $idQuadrado)[0];
}

// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idQuadrado =  isset($_POST['idQuadrado']) ? $_POST['idQuadrado'] : 0;
    $ladoTamanho =  isset($_POST['ladoTamanho']) ? $_POST['ladoTamanho'] : 0;
    $cor =  isset($_POST['cor']) ? $_POST['cor'] : 0;
    $UnidadeMedida =  isset($_POST['UnidadeMedida']) ? $_POST['UnidadeMedida'] : 0;
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : 0;



    try {
        $quadrado = new Quadrado($idQuadrado, $ladoTamanho, $cor, $UnidadeMedida);
        var_dump($quadrado);
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
        echo "TAMANHO:$ladoTamanho<br>COR:$cor<br>UNIDADE:$UnidadeMedida";
    }
    $resultado = "";

    

    switch ($acao) {
        case "salvar":
            $resultado = $quadrado->incluir();
            break;
        case "alterar":
            $resultado = $quadrado->alterar();
            break;
        case "excluir":
            $resultado = $quadrado->excluir();
            break;
    }

    if ($resultado)
        header('location: index.php?MSG=Dados inseridos/Alterados com sucesso!');
    else
        header('location: index.php?MSG=Erro ao inserir/alterar registro');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Quadrado::listar($tipo, $busca);
}
