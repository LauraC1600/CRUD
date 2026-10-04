<?php

if (!function_exists('obtener_conexion')) {
    function obtener_conexion()
    {
        global $conex;

        if (!isset($conex)) {
            require_once __DIR__ . '/../../db/conexion.php';
        }

        return $conex;
    }
}

function insert_usuario(string $name, string $last_name, string $cedula, string $email, string $passwore, string $telefono): bool
{
    try {
        $conex = obtener_conexion();

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