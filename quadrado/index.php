<?php  
include_once('quadrado.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Quadrados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            margin-top: 20px;
        }

        header button {
            margin: 5px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        header button a {
            text-decoration: none;
            color: white;
        }

        fieldset {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 600px;
            margin: 20px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="color"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        hr {
            margin: 20px 0;
        }

        .search-form {
            margin: 20px 0;
            width: 90%;
            max-width: 600px;
        }

        .search-form input,
        .search-form select,
        .search-form button {
            width: 100%;
            margin-top: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .square-list {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .square-list div {
            width: 100%;
            padding: 10px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <header>
        <button><a href="../circulo/">Círculo</a></button>
        <button><a href="../triangulo/">Triângulo</a></button>
    </header>

    <form action="quadrado.php" method="post">
        <fieldset>
            <legend>Insira as Informações sobre o Quadrado</legend>

            <label for="idQuadrado">Id:</label>
            <input type="text" id="idQuadrado" name="idQuadrado" value="<?=isset($forma)?$forma->getIdQuadrado():0 ?>" readonly>

            <label for="lado">Lado:</label>
            <input type="text" id="lado" name="lado" value="<?php if(isset($forma)) echo $forma->getLado()?>">

            <label for="cor">Cor:</label>
            <input type="color" id="cor" name="cor" value="<?php if(isset($forma)) echo $forma->getCor()?>">
             
            <label for="UnidadeMedida">Unidade de Medida:</label>
            <select name="UnidadeMedida" id="UnidadeMedida">
                <?php 
                    $uns = UnidadeMedida::listar();
                    foreach ($uns as $un){
                        $str= "<option value='{$un->getIdUnidade()}'";
                        if(isset($forma))
                           if($forma->getUnidade()->getIdUnidade() == $un->getIdUnidade())
                              $str .=" selected ";
                        $str .= ">{$un->getUnidadeMedida()}</option>";
                        echo $str;
                    }
                ?>
            </select>
            <br><br>
                            
            <button type="submit" name="acao" value="salvar">Salvar</button>
            <button type="submit" name="acao" value="excluir">Excluir</button>
            <button type="submit" name="acao" value="alterar">Alterar</button>
        </fieldset>
    </form>

    <form action="" method="get" class="search-form">
        <fieldset>
            <legend>Pesquisa</legend>

            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value="">

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Escolha</option>
                <option value="1">Id</option>
                <option value="2">Cor</option>
                <option value="3">Lado</option>
                <option value="4">Unidade Medida</option>
            </select>

            <button type="submit">Buscar</button>
        </fieldset>
    </form>

    <hr>

    <h1>Lista de Quadrados</h1>

    
        <?php  
            foreach($lista as $quadrado){ 
              echo "<div>" . $quadrado->desenhar() . "</div>";
              echo  $quadrado->calcularPerimetro() ."<br>";
              echo  $quadrado->calculararea() ."<br><br>";
            }
        ?>
   
</body>

</html>