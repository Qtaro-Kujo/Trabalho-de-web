<?php
//criar tabela para usuário//
require 'bd_credentials.php';

// criar conexão//
$conn = mysqli_connect($servername, $username, $db_password);
// validar conexão//
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ESCOLHER BD //
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Banco de dados atualizado";
} else {
    echo "<br>Erro ao criar banco de dados: " . mysqli_error($conn);
}

// SQL PARA CRIAR TABLE //
$sql = "CREATE TABLE jogador (
  id INT(6) AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(45) NOT NULL,
  raça VARCHAR(45) NOT NULL,
  classe VARCHAR(45) NOT NULL,
  imagem BLOB NOT NULL,
  iduser INT NOT NULL,
  CONSTRAINT fkchar FOREIGN KEY (iduser) REFERENCES usuarios(idusuarios))";
  

if (mysqli_query($conn, $sql)) {
    echo "<br>Banco de dados criado com sucesso";
} else {
    echo "<br>Erro ao criar banco de dados: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
