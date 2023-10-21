<?php
function limpar_texto($str){
    return preg_replace("/[^0-9]/", "", $str);
}

$erros = array();

if (isset($_POST['enviar'])) {
    include('conexao.php');
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];
    $grupo = $_POST['grupo'];

    if (empty($nome)) {
        $erros[] = "Preencha o nome";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "Preencha um e-mail válido";
    }
    if (empty($grupo)) {
        $erros[] = "Preencha o grupo";
    }

    if (!empty($data_nascimento)) {
        $pedacos = explode('/', $data_nascimento);
        if (count($pedacos) == 3) {
            $data_nascimento = implode('-', array_reverse($pedacos));
        } else {
            $erros[] = "A data de nascimento deve estar no formato dia/mês/ano.";
        }
    }

    if (!empty($telefone)) {
        $telefone = limpar_texto($telefone);
    }

    if (!empty($erros)) {
        foreach ($erros as $erro) {
            echo "Erro: $erro<br>";
        }
    } else {
        $sql_code = "INSERT INTO clientes (nome, email, telefone, data_nascimento, grupo) 
        VALUES ('$nome', '$email', '$telefone', '$data_nascimento', '$grupo')";

        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);

        if ($deu_certo) {
            echo "Cliente cadastrado com sucesso";
            unset($_POST);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do cliente</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="navbar">
    <a class="active" href="#Início">Cadastro de cliente</a>
    <a href="./clientes.php">Lista de clientes</a>
    </div>
    <h1 class="main_tittle">Cadastro dos clientes</h1>
    <form action="" method="post">
    <div class= "align">
    <form action="" method="post">
        <div class="label">   
            <label>Nome:</label> 
            <input class="input" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" type="text" name="nome" id="">
        </div>
        <div class="label">
            <label>E-mail:</label>    
            <input class="input" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="text" name="email" id="">
        </div>
        <div class="label">
            <label>telefone:</label>
            <input class="input" value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" type="text" name="telefone" id="">
        </div>
        <div class="label">
            <label>data de nascimento:</label>
            <input class="input" value="<?php if(isset($_POST['data_nascimento'])) echo $_POST['data_nascimento']; ?>" type="text" name="data_nascimento" id="">
        </div>
        <div class="label">
            <label>Grupo:</label>
            <input class="input" value="<?php if(isset($_POST['grupo'])) echo $_POST['grupo']; ?>" type="text" name="grupo" id="">
        </div>
        <div class="btn">
            <button class= "btnEnviar"class="submit" name="enviar">Enviar</button>
        </div>
    </form>
</body>
</html>