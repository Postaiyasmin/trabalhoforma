<?php  
include_once('quadrado.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formas</title>
</head>
<body> <br> 
    <form action="quadrado.php" method="post" >
        <fieldset>

            <label for="idQuadrado">Id: </label>
            <input type="text" id="idQuadrado" name="idQuadrado" value="<?=isset($forma)?$forma->getIdQuadrado():0 ?>" readonly> 
            
            <label for="lado">Lado: </label>
            <input type="text" id="lado" name="lado" value="<?php if(isset($forma)) echo $forma->getLado()?>"> 
            
            <label for="cor">Cor: </label>
            <input type="color" id="cor" name="cor" value="<?php if(isset($forma)) echo $forma->getCor()?>"> 
            
            <label for="UnidadeMedida">Unidade de Medida</label>
            
            <select name="UnidadeMedida" id="UnidadeMedida">
            <?php 
                $uns = UnidadeMedida::listar();
                foreach ($uns as $un){
                    $str= "<option value='{$un->getIdUnidade()}'";
                    if(isset($forma))
                       if($forma->getUnidade()-> getIdUnidade() == $un->getIdUnidade())
                       $str .=" selected ";
                       $str .= ">{$un->getUnidadeMedida()}</option>";
                       echo $str;
                }
               ?>
            </select>
            
            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name='acao' value='alterar'>Alterar</button>
    <br>

        </fieldset>
    </form>
        <br>
        <form action="" method="get" style="text-align:center">
        <fieldset style="margin-left: 600px; margin-right:600px">
            <legend style="text-align:center">Pesquisa</legend>
            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value=""><br>
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Escolha</option>
                <option value="1">Id</option>
                <option value="2">Cor</option>
                <option value="3">Lado</option>
                <option value="4">Unidade Medida</option>
            </select>
            <button type='submit'>Buscar</button>
        </fieldset>
    </form> <br>

    <hr>
    <h1 style="text-align: center;">Lista meus Quadrados</h1>

        <?php  
            foreach($lista as $quadrado){ 
              echo  $quadrado->desenhar();

            }     
        ?>
       
</body>
</html>