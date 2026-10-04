<?php
session_start();
if (empty($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../includes/users/get.php';

$usuarios = obtener_usuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Usuarios registrados</h1>
    <a href="../form/registrar.php">Nuevo Usuario</a>
    <!-- <input type="button" value="Nuevo Usuario" onclick="window.location.href='../form/registrar.php'"> -->
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cedula</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>opciones</th>
            </tr>
        </thead>
        <tbody>


            <?php while ($user = mysqli_fetch_assoc($usuarios)) { ?>
                <tr>
                    <td><?php echo $user["name"] ?></td>
                    <td><?php echo $user["last_name"] ?></td>
                    <td><?php echo $user["cedula"] ?></td>
                    <td><?php echo $user["email"] ?></td>
                    <td><?php echo $user["telefono"] ?></td>
                    <?php $id = $user["id"] ?>
                    <td> <a href="../includes/users/update.php?id=<?php echo $id; ?>">Update</a> | 
                    <a href="../includes/users/delete.php?id=<?php echo $id; ?>" onclick="alert('¿Esta seguro de eliminar este registro?')">Delete</a></td>
                </tr>
            <?php  } 
            ?>

        </tbody>
    </table>
    <?php
    echo '<a href="cerrarSesion.php">Cerrar sesion</a>';
    ?>
</body>

</html>