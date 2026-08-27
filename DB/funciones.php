<?php


function obtener_usuarios()
{
    try {
        // 1 importar la conexion
        require 'conexion.php';
        // 2. consultar la DB 
        $sql = "SELECT * FROM USUARIO;";
        $query = mysqli_query($conex, $sql);
        // 3. ejecutar la consulta
        mysqli_query($conex, $sql);
        //4 acceder a los resultados
        // echo '<pre>';
        // var_dump($query);
        // var_dump(mysqli_fetch_assoc($query));
        // echo '</pre>';
        // 5. cierre de conexion (opcional)
        return $query;
        // mysqli_close($conex);
    } catch (\Throwable $th) {
        var_dump($th);
    }
}

function insert_usuario(string $name, string $last_name, string $cedula, string $email, string $passwore, string $telefono): bool
{
    try {
        require './DB/conexion.php';

        $name      = mysqli_real_escape_string($conex, $name);
        $last_name = mysqli_real_escape_string($conex, $last_name);
        $cedula    = mysqli_real_escape_string($conex, $cedula);
        $email     = mysqli_real_escape_string($conex, $email);
        $passwore  = mysqli_real_escape_string($conex, password_hash($passwore, PASSWORD_BCRYPT));
        $telefono  = mysqli_real_escape_string($conex, $telefono);

        $sql = "INSERT INTO usuario (name, last_name, cedula, email, passwore, telefono) 
                VALUES ('$name', '$last_name', '$cedula', '$email', '$passwore', '$telefono')";

        return mysqli_query($conex, $sql);
    } catch (\Throwable $th) {
        var_dump($th);
        return false;
    }
}

function validar_usuario(string $name, string $last_name, string $cedula, string $email, string $passwore, string $confirmar_passwore, string $telefono): array
{
    $errores = [];

    if (empty($name))      $errores[] = "El nombre es obligatorio.";
    if (empty($last_name)) $errores[] = "El apellido es obligatorio.";
    if (empty($cedula))    $errores[] = "La cédula es obligatoria.";
    if (empty($email))     $errores[] = "El email es obligatorio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    elseif (email_existe($email)) $errores[] = "El email ya está registrado.";
    if (empty($passwore))  $errores[] = "La contraseña es obligatoria.";
    elseif (strlen($passwore) < 6) $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    elseif ($passwore !== $confirmar_passwore) $errores[] = "Las contraseñas no coinciden.";
    if (empty($telefono))  $errores[] = "El teléfono es obligatorio.";

    return $errores;
}
function email_existe(string $email): bool
{
    require './DB/conexion.php';
    $email = mysqli_real_escape_string($conex, $email);
    $sql = "SELECT id FROM usuario WHERE email = '$email'";
    $query = mysqli_query($conex, $sql);
    return mysqli_num_rows($query) > 0;
}