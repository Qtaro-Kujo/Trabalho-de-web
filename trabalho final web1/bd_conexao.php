<?php
require "bd_credentials.php";

function connect_db(){
  global $servername, $username, $dbname, $db_password;
  $conn = mysqli_connect($servername, $username, $dbname, $db_password,);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  return($conn);
}

function disconnect_db($conn){
  mysqli_close($conn);
}

?>
