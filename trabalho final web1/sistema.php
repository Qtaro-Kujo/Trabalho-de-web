<?php

//VERIFICA E NÃO PERMITE QUE ENTRE SEM ESTAR LOGADO//
session_start();
if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('location: login.php');
}
$logado = $_SESSION['usuario'];

//**** INSERE DADOS NO BANCO DE DADOS  ******/
require "bd_conexao.php";

$error = false;
$success = false;

//******* VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS ***********//

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"]) && isset($_POST["raça"]) && isset($_POST["classe"]) && isset($_POST["imagem"])) {
  
        $conn = connect_db();

        //******* LIMPA STRING ***********//
        
        $nome = mysqli_real_escape_string($conn,$_POST["nome"]);
        $raça= mysqli_real_escape_string($conn,$_POST["raça"]);
        $classe = mysqli_real_escape_string($conn,$_POST["classe"]);

        //******* limpa imagem ******//

        $imagem = $_FILES["imagem"];
        if($imagem != NULL) { 
            $nomeFinal = time().'.jpg';
            if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
                $tamanhoImg = filesize($nomeFinal); 
        
                $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));  
        
                unlink($nomeFinal);   
            }
        } 
        else { 
           $error_msg = "houve algum problema";
        }

        //SALVA ID DE USUÁRIO LOGADO//
        
        $sql = "SELECT idusuarios FROM usuarios WHERE (username = '$logado')";
        $result = mysqli_query($conn, $sql);

        //INSERE NO BANCO DE DADOS//
        
        $sql = "INSERT INTO Personagem (nome, raça, classe, imagem, iduser) VALUES ('$nome', '$raça', '$classe', '$mysqlImg', '$iduser')";
  
        if(mysqli_query($conn, $sql)){
          $success = true;
        }
        else {
          $error_msg = mysqli_error($conn);
          $error = true;
        }
    }
    else {
        $error_msg = "Senha não confere.";
        $error = true;
      }
    }
    else {
      $error_msg = "Todos os dados devem estar preenchidos.";
      $error = true;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="sistema.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;800&display=swap" rel="stylesheet">
    <title>Sistema</title>
</head>
<body>
    <header>
        <nav>
            <h1 id="logo"> Bem-vindo <?php echo $logado ?></h1>

            <ul class="navlist">
                <li><a href="sair.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <aside>
            <h2> Salve seus personagens </h2>
            <p> Cadastre aqui os personagens criados para a sua sessão <br></p>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <div class="textfield">
                    <label for="usuario">Nome</label>
                    <input type="text" name="nome" required>
                </div>
                <div class="textfield">
                    <label for="raça">Raça</label>
                    <input type="text" name="raça" required>
                </div>
                <div class="textfield">
                    <label for="classe">Classe</label>
                    <input type="text" name="classe" required>
                </div>
                <div class="textfield">
                    <label for="imagem">Imagem</label>
                    <input type="file" name="imagem" required>
                </div>
                <input type="submit" id="enviar" name="cadastrou" value="Cadastrar">
            </form>
        </aside>
        <div class="coluna">
            <h2> Seus personagens <br></h2>
        </div>
    </main>
 </body>
 </html>