<?php
require_once('../Config/conexion.php');

function conectar() {
  global $servername, $username, $password, $dbname;
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
  }
  return $conn;
}

function agregarUsuario($nombre, $email, $password) {
  $conn = conectar();
  $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
  if (mysqli_query($conn, $sql)) {
    echo "Usuario registrado exitosamente";
  } else {
    echo "Error al registrar el usuario: " . mysqli_error($conn);
  }
  mysqli_close($conn);
}

function obtenerUsuarios() {
  $conn = conectar();
  $sql = "SELECT * FROM usuarios";
  $result = mysqli_query($conn, $sql);
  $usuarios = array();
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($usuarios, $row);
    }
  }
  mysqli_close($conn);
  return $usuarios;
}
?>
