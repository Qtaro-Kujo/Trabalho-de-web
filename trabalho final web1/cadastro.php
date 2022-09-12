<?php
require "bd_conexao.php";

$error = false;
$success = false;
$usuario = $email = "";

// VERIFICAÇÃO PARA ENTRADA DE TODOS OS DADOS //

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["usuario"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["senhaconfirm"])) {
  
        $conn = connect_db();

        // LIMPA STRING //
        
        $usuario = mysqli_real_escape_string($conn,$_POST["usuario"]);
        $email = mysqli_real_escape_string($conn,$_POST["email"]);
        $senha = mysqli_real_escape_string($conn,$_POST["senha"]);
        $senhaconfirm = mysqli_real_escape_string($conn,$_POST["senhaconfirm"]);

     // CONFIRMA SENHA //   

    if ($senha == $senhaconfirm) {
        $senha = md5($senha);

  
        $sql = "INSERT INTO $table_users
                (username, email, senha) VALUES
                ('$usuario', '$email', '$senha');";

        // INSERE NO BANCO DE DADOS //         
  
        if(mysqli_query($conn, $sql)){
          $success = true;
        }
        else {
          $error_msg = mysqli_error($conn);
          $error = true;
        }
    }
    else {
        $error_msg = "Senha inválida.";
        $error = true;
      }
    }
    else {
      $error_msg = "Você deve preencher todos os campos.";
      $error = true;
    }
  } 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="csscadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;800&display=swap" rel="stylesheet">
    <title>Cadastro</title>
</head>
<body>
    <div class="main-login">
        <div class="esquerda-login"></div>
        <div class="direita-login">
            <div class="card-login">
                <h1>CADASTRO</h1>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="textfield">
                        <label for="usuario">Nome de usuário</label>
                        <input type="text" name="usuario" value="<?php echo $usuario; ?>" required>
                    </div>
                    <div class="textfield">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="textfield">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senhainput" required>
                    </div>
                    <div class="textfield">
                        <label for="senhaconfirm">Confirmar senha</label>
                        <input type="password" name="senhaconfirm" id="senhac" required>
                    </div>
                    <input type="submit" name="enviar" id="enviar" value="Cadastrar">
                </form>
                <a href="login.php" class="fazerlogin">Fazer login</a>

                <?php if ($success): ?>
                    <h3>Cadastro realizado com sucesso</h3>
                <?php endif; ?>

                <?php if ($error): ?>
                    <h3 id="erro"><?php echo $error_msg; ?></h3>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>
