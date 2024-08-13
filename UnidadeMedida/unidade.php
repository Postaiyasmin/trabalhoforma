<?php
require_once("../classes/Database.class.php");
require_once("../classes/UnidadeMedida.class.php");

$conexao = new PDO(DSN, USUARIO, SENHA);


$idUnidade =  isset($_GET['idUnidade']) ? $_GET['idUnidade'] : 0;
$msg =  isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($idUnidade > 0) {
    $unidade = UnidadeMedida::listar(1, $idUnidade)[0];
}

// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUnidade =  isset($_POST['idUnidade']) ? $_POST['idUnidade'] : 0;
    $unidadeMedida =  isset($_POST['unidadeMedida']) ? $_POST['unidadeMedida'] : 0;
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : 0;

    
    try {
        $unidade = new UnidadeMedida($idUnidade, $unidadeMedida);
        var_dump($unidade);
    } catch (Exception $e) {
        // header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }

    switch ($acao) {
        case "salvar":
            $resultado = $unidade->incluir();
            break;
        case "alterar":
            $resultado = $unidade->alterar();
            break;
        case "excluir":
            $resultado = $unidade->excluir();
            break;
    }

    if ($resultado)
        header('location: index.php?MSG=Dados inseridos/Alterados com sucesso!');
    else
        header('location: index.php?MSG=Erro ao inserir/alterar registro');
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = UnidadeMedida::listar($tipo, $busca);
}