<?php
session_start();
require './db/funciones.php';

$errores = [];
$email   = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"]    ?? '');
    $passwore = trim($_POST["passwore"] ?? '');

    $errores = validar_usuario($email, $passwore);

    if (empty($errores)) {
        $usuario = login($email, $passwore);

        if ($usuario) {
            $_SESSION['usuario_id']    = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header('Location: ingreso.php');
            exit;
        } else {
            $errores[] = "informacion incorrecta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <h1>Iniciar sesión</h1>

    <?php if (!empty($errores)): ?>
        <div style="color: red;">
            <?php foreach ($errores as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <label>Email:</label>
        <input type="email" name="email" value="<?= $email ?>">
        <br>

        <label>Contraseña:</label>
        <input type="password" name="passwore">
        <br>

        <button type="submit">Ingresar</button>

    </form>

</body>
</html>