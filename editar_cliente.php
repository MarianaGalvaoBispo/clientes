
<?php 
include('conexao.php');
$id= intval($_GET['id']); 

function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
  }
  
$erro = false;
if(isset($_POST['enviar'])){


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
            $sql_code = "UPDATE clientes
            SET nome='$nome',
            email='$email',
            telefone='$telefone',
            data_nascimento='$data_nascimento'
            WHERE id = '$id'";
            $deu_certo= $mysqli->query($sql_code) or die($mysqli->error);
            if($deu_certo){
                echo "Cliente atualizado com sucesso";
                unset($_POST);
            }
        }
    }
}
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'"; //para pegar apenas o id escolhido
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar o cliente</title>

</head>
<body>
    <form action="" method="post">
        <a href="./clientes.php">Voltar para a lista</a>
        <br><br>
        <p>
            <label>Nome:</label>
            <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome" id="">
        </p>
        <p>

            <label>E-mail:</label>
            <input value="<?php echo $cliente['email']; ?>" type="text" name="email" id="">
        </p>
        <p>

        </p>
            <label>Telefone:</label>
            <input value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>"placeholder="(11)99999-9999" type="text" name="telefone" id="">
        <p>
            <label>Data de nascimento:</label>
            <input value="<?php if(!empty($cliente['data_nascimento'])) echo formatar_data($cliente['data_nascimento']); ?>" type="text" name="data_nascimento" id="">
        </p>
        <br><br>
        <button type="submit" name="enviar">Enviar</button>
    </form>
</body>
</html>