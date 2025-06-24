<?php
require '../2FE/verificacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $codigo = $_SESSION['secret']; 

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $registro = $resultado->fetch_assoc();

    if ($registro) {
        // Redirigir si el usuario es válido
        header('Location: ../2FE/verificacion2FE.php');
        exit;
    } else {
        echo "Usuario no conectado";
    }

    $stmt->close();
} else {
    echo "Datos incompletos";
}
?>