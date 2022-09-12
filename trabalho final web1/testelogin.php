<?php
session_start();
require "bd_conexao.php";
$error = false;

//acessa paginas//
if(isset($_POST['entrar']) && !empty($_POST['usuario']) && !empty($_POST['senha']))
{
    $conn = connect_db();

    //limpa strings//
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conn,$_POST['senha']);
    $senha = md5($senha);

    //insere bd//
    $sql = "SELECT * FROM usuarios WHERE nomeusuario = '$usuario' and senha= '$senha'";
    $result = mysqli_query($conn, $sql);

    //x < 1 = conta não encontrada no bd //
    if(mysqli_num_rows($result) < 1)
    {
        //limpa variaves que tiver usuario e senha
        unset($_SESSION['usuario']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    else
    {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;
        header('Location: sistema.php');
    }
}
//não acessa paginas, volta para o login//
else
{
    header('location: login.php');
}
?>
