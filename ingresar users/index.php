<?php
require './DB/funciones.php';

$errores = [];
$exito = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name               = trim($_POST["name"]);
    $last_name          = trim($_POST["last_name"]);
    $cedula             = trim($_POST["cedula"]);
    $email              = trim($_POST["email"]);
    $passwore           = trim($_POST["passwore"]);
    $confirmar_passwore = trim($_POST["confirmar_passwore"]);
    $telefono           = trim($_POST["telefono"]);

    $errores = validar_usuario($name, $last_name, $cedula, $email, $passwore, $confirmar_passwore, $telefono);

    if (empty($errores)) {
        $exito = insert_usuario($name, $last_name, $cedula, $email, $passwore, $telefono);
        if ($exito) {
            $name = $last_name = $cedula = $email = $passwore = $confirmar_passwore = $telefono = '';
        }
    }
}


$usuarios = obtener_usuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejemplo de conexion DB</title>
</head>

<body>
    <h1>Conexión con mysqli</h1>

    <h2>Agregar usuario</h2>

    <?php if (!empty($errores)) { ?>
        <div>
            <?php foreach ($errores as $error) { ?>
                <p><?php echo $error ?></p>
            <?php } ?>
        </div>
    <?php } ?>


    <?php if ($exito): ?>
        <p>se agrego un usuario corerctamente</p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="name" value="<?php echo $name ?? '' ?>"><br>

        <label>Apellido:</label>
        <input type="text" name="last_name" value="<?php echo $last_name ?? '' ?>"><br>

        <label>Cédula:</label>
        <input type="text" name="cedula" value="<?php echo $cedula ?? '' ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email ?? '' ?>"><br>
        
        <label>Contraseña:</label>
        <input type="password" name="passwore"><br>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="confirmar_passwore"><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $telefono ?? '' ?>"><br>

        <button type="submit">Agregar</button>
    </form>

    <hr>

    <h2>Usuarios registrados</h2>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
            </tr>
        </thead>
        <tbody>

            <?php /* foreach ($usuarios as $user): ?>
                <tr>ñ
                    <td><?php echo $user["name"] ?></td>
                    <td><?php echo $user["last_name"] ?></td>
                </tr>
            <?php endforeach;  */ ?>


            <?php while ($user = mysqli_fetch_assoc($usuarios)) { ?>
                <tr>
                    <td><?php echo $user["name"] ?></td>
                    <td><?php echo $user["last_name"] ?></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>

</html>