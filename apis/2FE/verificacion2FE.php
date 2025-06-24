<?php
require '../2FE/verificacion.php';
require __DIR__ . '/vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

session_start();

$g = new GoogleAuthenticator();

if (!isset($_SESSION['secret'])) {
    $secret = $g->generateSecret();
    $_SESSION['secret'] = $secret;
    $qrCodeUrl = $g->getURL('usuario', 'TuApp', $secret);
    $mostrarQR = true;
} else {
    $secret = $_SESSION['secret'];
    $qrCodeUrl = $g->getURL('usuario', 'TuApp', $secret);
    $mostrarQR = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
        $error = "Por favor introduce un código";
    } else {
        $codigo = trim($_POST['codigo']);
        if ($g->checkCode($secret, $codigo)) {
            $_SESSION['authenticated'] = true;
            header('Location: bienvenida.html');
            exit;
        } else {
            $error = "Código incorrecto. Por favor intenta nuevamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación en Dos Factores</title>
    <style>
        .container { max-width: 500px; margin: 0 auto; padding: 20px; text-align: center; }
        .error { color: red; margin: 10px 0; }
        .qr-code { margin: 20px 0; }
        .secret { font-size: 18px; color: #0071ff; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Autenticación en Dos Factores</h2>
        <?php if ($mostrarQR): ?>
            <p>Escanea este código QR con Google Authenticator para registrar tu cuenta:</p>
            <div class="qr-code">
                <img src="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=<?= urlencode($qrCodeUrl) ?>" alt="Código QR para autenticación">
            </div>
            <div class="secret">Código secreto: <strong><?= htmlspecialchars($secret) ?></strong></div>
            <p>Después de registrar, ingresa el código generado por la app:</p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="codigo">Introduce el código de Google Authenticator:</label><br>
            <input type="text" id="codigo" name="codigo" required autocomplete="off" autofocus>
            <button type="submit">Verificar</button>
        </form>
    </div>
</body>
</html>