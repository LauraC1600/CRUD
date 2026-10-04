<?php

require_once __DIR__ . '/../includes/users/get.php';

function validar_usuario_pass(string $email, string $passwore): array
{
    $errores = [];

    if (empty($email))          $errores[] = "El email es obligatorio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    elseif (!email_existe($email)) $errores[] = "El email no está registrado.";

    if (empty($passwore))       $errores[] = "La contraseña es obligatoria.";

    return $errores;
}





function validar_usuario(string $name, string $last_name, string $cedula, string $email, string $passwore, string $confirmar_passwore, string $telefono): array
{
    $errores = [];

    if (empty($name))      $errores[] = "El nombre es obligatorio.";
    elseif (!is_string($name) || is_numeric($name)) $errores[]="El nombre debe ser solo texto";
    if (empty($last_name)) $errores[] = "El apellido es obligatorio.";
    elseif (!is_string($last_name) || is_numeric($last_name))$errores[]="El nombre debe ser solo texto";
    if (empty($cedula))    $errores[] = "La cédula es obligatoria.";
    elseif(!ctype_digit($cedula)) $errores[] = "La cédula debe contener solo números.";
    elseif (cedula_existe($cedula)) $errores[] = "La cedula ya está registrada.";
    elseif(strlen((string)$cedula)< 9 ) $errores[] ="La cedula debe ser minimo de 9 dijitos"; 
    if (empty($email))     $errores[] = "El email es obligatorio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    elseif (email_existe($email)) $errores[] = "El email ya está registrado.";
    if (empty($passwore))  $errores[] = "La contraseña es obligatoria.";
    elseif (strlen($passwore) < 6) $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    elseif ($passwore !== $confirmar_passwore) $errores[] = "Las contraseñas no coinciden.";
    if (empty($telefono))  $errores[] = "El teléfono es obligatorio.";
    elseif(strlen((string)$telefono)< 9 ) $errores[] ="El telefono debe ser minimo de 9 dijitos"; 

    return $errores;
}


function validar_usuario_actualizar(int $id, string $name, string $last_name, string $cedula, string $email, string $telefono): array
{
    $errores = [];

    if (empty($name))      $errores[] = "El nombre es obligatorio.";
    elseif (!is_string($name) || is_numeric($name)) $errores[]="El nombre debe ser solo texto";
    if (empty($last_name)) $errores[] = "El apellido es obligatorio.";
    elseif (!is_string($last_name) || is_numeric($last_name))$errores[]="El apellido debe ser solo texto";
    if (empty($cedula))    $errores[] = "La cédula es obligatoria.";
    elseif(!ctype_digit($cedula)) $errores[] = "La cédula debe contener solo números.";
    elseif (cedula_existe($cedula, $id)) $errores[] = "La cedula ya está registrada.";
    elseif(strlen((string)$cedula)< 9 ) $errores[] ="La cedula debe ser minimo de 9 dijitos";
    if (empty($email))     $errores[] = "El email es obligatorio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    elseif (email_existe($email, $id)) $errores[] = "El email ya está registrado.";
    if (empty($telefono))  $errores[] = "El teléfono es obligatorio.";
    elseif(strlen((string)$telefono)< 9 ) $errores[] ="El telefono debe ser minimo de 9 dijitos";

    return $errores;
}

$status = isset($_GET['status']) ? (int) $_GET['status'] : 0;
function resultado($status){

    var_dump($status);
}

