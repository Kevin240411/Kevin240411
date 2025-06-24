<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname= "api";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer el conjunto de caracteres a utf8
mysqli_set_charset($conn, "utf8");
?>
