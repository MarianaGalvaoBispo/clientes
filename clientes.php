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
</head>
<body>
    <h1>Lista de clientes</h1>
    <p>Estes são os clientes cadastrados no seu sistema</p>
    <table border="1" celpadding="10">
        <thead>
            <th>ID</th>
            <TH>Nome</TH>
            <th>E-mail</th>
            <TH>telefone</TH>
            <TH>Nascimento</TH>
            <th>data de cadastro</th>
            <TH>Ações</TH>
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
                    $data_nascimento = "Não informado";  //arrumando a data
                    if(!empty($cliente['data_nascimento'])){
                        $data_nascimento = implode('/', array_reverse(explode('-', $cliente['data_nascimento'])));
                    }
                    $data_cadastro= date("d/m/Y H:i", strtotime($cliente['data_cadastro']));   //arrumando a datatime
                    
                    ?> 
            <tr>
                <td><?php echo $cliente['id']?></td>
                <td><?php echo $cliente['nome']?></td>
                <td><?php echo $cliente['email']?></td>
                <td><?php echo $telefone;?></td>
                <td><?php echo $data_nascimento;?></td>
                <td><?php echo $cliente['data_cadastro']?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                    <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                </td>


            </tr>            
            <?php
                }
         }?>
        </tbody>
    </table>
</body>
</html>