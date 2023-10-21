<?php 
include('conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
$num_clientes = $query_clientes->num_rows;

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
    <a href="./index.php">Cadastro de cliente</a>
    <a class= "active" href="#Lista">Lista de clientes</a>
    </div>
    <h1>Lista de clientes</h1>
    <p>Estes são os clientes cadastrados no seu sistema</p>
    <table class= "customers">
        <thead> 
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>telefone</th>
            <th>idade</th>
            <th>Grupo</th>

        </thead>
        <tbody>
            <?php if($num_clientes == 0) { ?>
                <tr>
                    <td colspan="7">Nunhum cliente foi cadastrados</td> 
                </tr>
            <?php 
            }else { 
                while ($cliente = $query_clientes->fetch_assoc()) { //arrumando o telefone
                    $telefone = "Não informado";
                    if(!empty($cliente['telefone'])){
                        $telefone=formatar_telefone($cliente['telefone']);
                    }
                    $data_nascimento = "Não informado";  //arrumando a data para idade
                    if(!empty($cliente['data_nascimento'])){
                    $data_nascimento_formatada = implode('/', array_reverse(explode('-', $cliente['data_nascimento'])));
                    $idade = calcularIdade($data_nascimento_formatada);
                    }                    
                    ?> 
            <tr>
                <td><?php echo $cliente['id']?></td>
                <td><?php echo $cliente['nome']?></td>
                <td><?php echo $cliente['email']?></td>
                <td><?php echo $telefone;?></td>
                <td><?php echo $idade;?></td>
                <td><?php echo $cliente['grupo']?></td>
                <td>
                    <a class="btn_edit" href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                    <a class="btn_delete" href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                </td>
            </tr>            
            <?php
                }
         }?>
        </tbody>
    </table>
</body>
</html>