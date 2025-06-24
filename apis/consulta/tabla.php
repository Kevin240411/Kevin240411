<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$dbname = 'api';
$username = 'root';
$password = '';

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL
    $sql = 'SELECT id, nombre, apellidopaterno, apellidomaterno FROM registro';
    $stmt = $pdo->query($sql);
    
    // Preparar array para los resultados
    $usuarios = array();
    $usuarios["registros"] = array();
    
    // Recorrer resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usuario = array(
            "id" => $row['id'],
            "nombre" => $row['nombre'],
            "apellidopaterno" => $row['apellidopaterno'],
            "apellidomaterno" => $row['apellidomaterno']
        );
        array_push($usuarios["registros"], $usuario);
    }
    
    // HTTP 200 OK
    http_response_code(200);
    echo json_encode($usuarios);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("mensaje" => "Error al obtener los usuarios: " . $e->getMessage()));
}
?>