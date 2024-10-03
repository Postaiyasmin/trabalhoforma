<?php
    require_once("../classes/Triangulo.class.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Forma</title>
    <style>
        .modal{
            width:1024px;
            height: 1024px;
        }
    </style>
</head>
<body>
    <div class="modal">
    <?php
    
        $id =  isset($_GET['id'])?$_GET['id']:0; 
        
        if ($id > 0){
            $forma = Circulo::listar(1,$id)[0];                                          
        }
        echo $forma->desenhar();
    ?>
    </div>
</body>
</html>