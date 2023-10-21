<?php 
 if(isset($_POST['confirmar'])){

    include('conexao.php');
    $id=intval($_GET['id']);
    $sql_code= "DELETE FROM clientes WHERE id = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if($sql_query){ ?>
        <link rel="stylesheet" href="style.css">
        <h1 class="tittle_delete">Cliente deletado </h1>
        <a class= "btnVoltar" href="./clientes.php">Voltar</a>
        <?php 
        die();
    } 
 }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="tittle_delete">Tem certeza que deseja deletar esse cliente?</h1>
    
    <form class="btns" action="" method="post">
        <a class= "btnNo" href="./clientes.php">Não</a>
        <button class= "btnYes" name= "confirmar" value='1' type="submit">Sim</button>
    </form>
</body>
</html>