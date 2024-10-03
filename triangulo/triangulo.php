<?php
require_once("../classes/Database.class.php");
require_once("../classes/Triangulo.class.php");
require_once("../classes/UnidadeMedida.class.php");

$conexao = new PDO(DSN, USUARIO, SENHA);


$idTriangulo =  isset($_GET['idTriangulo']) ? $_GET['idTriangulo'] : 0;
$msg =  isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($idTriangulo > 0) {
    $forma = Triangulo::listar(1, $idTriangulo)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idTriangulo =  isset($_POST['idTriangulo']) ? $_POST['idTriangulo'] : 0;
    $lado1=  isset($_POST['lado1']) ? $_POST['lado1'] : 0;
    $lado2=  isset($_POST['lado2']) ? $_POST['lado2'] : 0;
    $lado3=  isset($_POST['lado3']) ? $_POST['lado3'] : 0;
    $tipo= isset($_POST['Tipo']) ? $_POST['Tipo'] : 0;
    $cor =  isset($_POST['cor']) ? $_POST['cor'] : 0;
    $unidade =  isset($_POST['UnidadeMedida']) ? $_POST['UnidadeMedida'] : 0;
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : 0;


    try {
        $Unids = UnidadeMedida::listar(1,$unidade)[0];
        $triangulo = new Triangulo($idTriangulo, $lado1, $lado2, $lado3,$tipo, $cor, $Unids);
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
        echo "TAMANHO:$ladoTamanho<br>COR:$cor<br>UNIDADE:$UnidadeMedida";
    }
    $resultado = "";

    

    switch ($acao) {
        case "salvar":
            $resultado = $triangulo->incluir();
            break;
        case "alterar":
            $resultado = $triangulo->alterar();
            break;
        case "excluir":
            $resultado = $triangulo->excluir();
            break;
    }

    if ($resultado)
        header('location: index.php?MSG=Dados inseridos/Alterados com sucesso!');
    else
        header('location: index.php?MSG=Erro ao inserir/alterar registro');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Triangulo::listar($tipo, $busca);
}
