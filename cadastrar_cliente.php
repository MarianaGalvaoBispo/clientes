<?php 
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
  }
  
$erro = false;
if(isset($_POST['enviar'])){

    include('conexao.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    if (empty($nome)){
        $erro = "Preencha o nome";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro = "Preencha o e-mail";
    }
    if ($erro) {
        echo $erro;
    } else {
        if (!empty($data_nascimento)){      
            $pedacos = explode('/', $data_nascimento);
            if (count($pedacos)==3) {
                $data_nascimento = implode('-', array_reverse($pedacos));

            } else {
                $erro = "A data de dascimento deve ser dia/mês/ano.";
            }
        }
        if(!empty($telefone)){
            $telefone= limpar_texto($telefone);
        }
        if($erro){
            echo "Erro: $erro ";
        } else {
            $sql_code = "INSERT INTO clientes (nome, email, telefone, data_nascimento, data_cadastro) 
            VALUES ('$nome','$email','$telefone','$data_nascimento', NOW())";
            $deu_certo= $mysqli->query($sql_code) or die($mysqli->error);
            if($deu_certo){
                echo "Cliente cadastrado com sucesso";
                unset($_POST);
            }
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

</head>
<body>
    <form action="" method="post">
        <a href="./clientes.php">Voltar para a lista</a>
        <br><br>
        <p>
            <label>Nome:</label> 
            <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" type="text" name="nome" id="">
        </p>
        <p>

            <label>E-mail:</label>    
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" type="text" name="email" id="">
        </p>
        <p>

        </p>
            <label>Telefone:</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>"placeholder="(11)99999-9999" type="text" name="telefone" id="">
        <p>
            <label>Data de nascimento:</label>
            <input value="<?php if(isset($_POST['data_nascimento'])) echo $_POST['data_nascimento']; ?>" type="text" name="data_nascimento" id="">
        </p>
        <br><br>
        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>