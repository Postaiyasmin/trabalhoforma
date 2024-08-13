<?php  
include_once('unidade.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formas</title>
</head>
<body> <br> 
    <form action="unidade.php" method="post" >
        <fieldset>

            <label for="idUnidade">Id: </label>
            <input type="text" id="idUnidade" name="idUnidade" value="<?=isset($forma)?$forma->getIdUnidade():0 ?>" readonly> 
            
            <label for="UnidadeMedida">Descrição </label>
            <input type="text" id="unidadeMedida" name="unidadeMedida" value="<?php if(isset($forma)) echo $forma->getUnidadeMedida()?>"> 
            
     
            
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
                <option value="1">Unidade Medida</option>
            </select>
            <button type='submit'>Buscar</button>
        </fieldset>
    </form> <br>

    <hr>
    <h1 style="text-align: center;">Lista meus Quadrados</h1>

        <?php  
            foreach($lista as $Unidade){ 
            
              echo  $Unidade->desenhar($Unidade);

            }     
        ?>
       
</body>
</html>