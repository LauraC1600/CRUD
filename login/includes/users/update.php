<?php
require_once __DIR__ . '/../../db/funciones.php';
require_once __DIR__ . '/get.php';

session_start();
if (empty($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

function actualizar_usuario(int $id, string $name, string $last_name, string $cedula, string $email, string $telefono, ?string $nuevo_hash = null): bool
{
    $conex = obtener_conexion();

    $name      = mysqli_real_escape_string($conex, $name);
    $last_name = mysqli_real_escape_string($conex, $last_name);
    $cedula    = mysqli_real_escape_string($conex, $cedula);
    $email     = mysqli_real_escape_string($conex, $email);
    $telefono  = mysqli_real_escape_string($conex, $telefono);

    $sql = "UPDATE usuario SET
                name = '$name',
                last_name = '$last_name',
                cedula = '$cedula',
                email = '$email',
                telefono = '$telefono'";

    if ($nuevo_hash !== null) {
        $nuevo_hash = mysqli_real_escape_string($conex, $nuevo_hash);
        $sql .= ", passwore = '$nuevo_hash'";
    }

    $sql .= " WHERE id = $id";

    return mysqli_query($conex, $sql);
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    header('Location: ../../pag/users.php');
    exit;
}

$conex   = obtener_conexion();
$query   = mysqli_query($conex, "SELECT * FROM usuario WHERE id = $id");
$usuario = mysqli_fetch_assoc($query);

if (!$usuario) {
    header('Location: ../../pag/users.php');
    exit;
}

$exito   = false;
$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name      = trim($_POST["name"]);
    $last_name = trim($_POST["last_name"]);
    $cedula    = trim($_POST["cedula"]);
    $email     = trim($_POST["email"]);
    $telefono  = trim($_POST["telefono"]);

    $passActual = trim($_POST["PassA"] ?? '');
    $passNueva  = trim($_POST["NewPass"] ?? '');
    $passConf   = trim($_POST["PassC"] ?? '');

    $errores = validar_usuario_actualizar($id, $name, $last_name, $cedula, $email, $telefono);

    $nuevo_hash = null;
    $quiere_cambiar_pass = !empty($passActual) || !empty($passNueva) || !empty($passConf);

    if ($quiere_cambiar_pass) {
        if (empty($passActual) || empty($passNueva) || empty($passConf)) {
            $errores[] = "Para cambiar la contraseña debes llenar los 3 campos.";
        } elseif (!password_verify($passActual, $usuario['passwore'])) {
            $errores[] = "La contraseña actual no coincide.";
        } elseif (strlen($passNueva) < 6) {
            $errores[] = "La nueva contraseña debe tener al menos 6 caracteres.";
        } elseif ($passNueva !== $passConf) {
            $errores[] = "La nueva contraseña y su confirmación no coinciden.";
        } else {
            $nuevo_hash = password_hash($passNueva, PASSWORD_BCRYPT);
        }
    }

    if (empty($errores)) {
        $exito = actualizar_usuario($id, $name, $last_name, $cedula, $email, $telefono, $nuevo_hash);
        if ($exito) {
            $usuario = ['name' => $name, 'last_name' => $last_name, 'cedula' => $cedula, 'email' => $email, 'telefono' => $telefono];
            header('Location: ../../pag/users.php?status=2');
        }
    } else {
        // conservar lo que el usuario escribió para no perder los datos en el formulario
        $usuario = ['name' => $name, 'last_name' => $last_name, 'cedula' => $cedula, 'email' => $email, 'telefono' => $telefono];
        header('Location: ../../pag/users.php?status=3');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Actualizar usuario</title>
</head>

<body>
    <h1>Actualizar usuario</h1>

    <?php if (!empty($errores)) { ?>
        <div style="color: red;">
            <?php foreach ($errores as $error) { ?>
                <p><?php echo $error ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if ($exito): ?>
        <p>Usuario actualizado correctamente</p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="name" value="<?php echo $usuario['name'] ?>"><br>

        <label>Apellido:</label>
        <input type="text" name="last_name" value="<?php echo $usuario['last_name'] ?>"><br>

        <label>Cédula:</label>
        <input type="text" name="cedula" value="<?php echo $usuario['cedula'] ?>" disabled><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email'] ?>"><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $usuario['telefono'] ?>"><br>

        <label>Contraseña Actual:</label>
        <input type="password" name="PassA"><br>

        <label>Nueva Contraseña:</label>
        <input type="password" name="NewPass"><br>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="PassC"><br>

        <button type="submit">Guardar cambios</button>
    </form>

    <a href="../../pag/users.php">Volver</a>

</body>

</html>
