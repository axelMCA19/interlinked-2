<?php
$direccionservidor="localhost";
$baseDatos="sistema";
$usuarioBD= "root";
$contraseniaBD="";


// Crear la conexión
$conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);

// Verificar si hay error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// $direccionservidor="localhost";
// $baseDatos="u409075324_sistema";
// $usuarioBD= "u409075324_interconectado";
// $contraseniaBD="A1@2-z.3.2";


?>