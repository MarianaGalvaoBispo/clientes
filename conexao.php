<?php 

$host= "localhost";
$db= "crud_clientes";
$user = "root";
$pass = "";

$mysqli= new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno){
    die("Erro na conexão com o banco de dados");
}
function formatar_data($data){
    return implode ('/', array_reverse(explode('-',$data)));
}
function calcularIdade($data_nascimento) {
    $data_nascimento = DateTime::createFromFormat('d/m/Y', $data_nascimento);
    $data_atual = new DateTime();
    $intervalo = $data_nascimento->diff($data_atual);
    return $intervalo->y;
}

function formatar_telefone($telefone){
    $ddd= substr ($telefone,0,2);
    $parte1=substr ($telefone,0,5);
    $parte2=substr ($telefone,7);
    return "($ddd) $parte1-$parte2";

}