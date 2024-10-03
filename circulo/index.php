<?php  
include_once('circulo.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Círculos</title>
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

        .circle-list {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .circle-list div {
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
        <button><a href="../triangulo/">Triângulo</a></button>
        <button><a href="../quadrado/">Quadrado</a></button>
    </header>

    <form action="circulo.php" method="post">
        <fieldset>
            <legend>Insira as Informações sobre o Círculo</legend>

            <label for="idCirculo">Id:</label>
            <input type="text" id="idCirculo" name="idCirculo" value="<?=isset($forma)?$forma->getId():0 ?>" readonly>
               
            <label for="diametro">Diâmetro:</label>
            <input type="text" id="diametro" name="diametro" value="<?php if(isset($forma)) echo $forma->getDiametro()?>">
              
            <label for="cor">Cor:</label>
            <input type="color" id="cor" name="cor" value="<?php if(isset($forma)) echo $forma->getCor()?>">
                <br><br>
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

            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name='acao' value='alterar'>Alterar</button>
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
                <option value="3">Diâmetro</option>
                <option value="4">Unidade de Medida</option>
            </select>

            <button type="submit">Buscar</button>
        </fieldset>
    </form>

    <hr>

    <h1>Lista de Círculos</h1>

   
        <?php  
            foreach($lista as $circulo){ 
              echo "<div>" . $circulo->desenhar() . "</div>";
              echo  "Perímetro:". $circulo->calcularPerimetro() ."<br>";
              echo  "Área:". $circulo->calculararea() ."<br><br>";

            }
        ?>
 
</body>

</html>