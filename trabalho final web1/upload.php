<?php
session_start();
if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
    header('location: login.php');
}
$logado = $_SESSION['usuario'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["imagem"]["size"] > 500000) {
  echo "Arquivo pesado demais.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "São compatíveis penas arquivos jpg, png, jpeg e gif.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $erroimg = "Desculpe, houve erro upar seu arquivo.";
  header('location: sistema.php');
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
    $sucessoimg = "O arquivo ". htmlspecialchars( basename( $_FILES["imagem"]["name"])). " foi upado com sucesso.";
    header('location: sistema.php');
  } else {
    $erroimg = "Desculpe, houve um erro ao upar seu arquivo.";
    header('location: sistema.php');
  }
}
?>
