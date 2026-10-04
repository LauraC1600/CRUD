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

function obtener_usuarios()
{
    try {
        $conex = obtener_conexion();
        $sql = "SELECT * FROM USUARIO;";
        $query = mysqli_query($conex, $sql);
        return $query;
    } catch (\Throwable $th) {
        var_dump($th);
    }
}


function email_existe(string $email, ?int $excluir_id = null): bool
{
    $conex = obtener_conexion();
    $email = mysqli_real_escape_string($conex, $email);
    $sql = "SELECT id FROM usuario WHERE email = '$email'";
    if ($excluir_id !== null) $sql .= " AND id != $excluir_id";
    $query = mysqli_query($conex, $sql);
    return mysqli_num_rows($query) > 0;
}

function cedula_existe(string $cedula, ?int $excluir_id = null): bool
{
    $conex = obtener_conexion();
    $cedula = mysqli_real_escape_string($conex, $cedula);
    $sql = "SELECT id FROM usuario WHERE cedula = '$cedula'";
    if ($excluir_id !== null) $sql .= " AND id != $excluir_id";
    $query = mysqli_query($conex, $sql);
    return mysqli_num_rows($query) > 0;
}

function login(string $email, string $passwore): array|false
{
    $conex     = obtener_conexion();
    $sql       = "SELECT id, email, passwore FROM usuario WHERE email = '$email'";
    $resultado = mysqli_query($conex, $sql);
    $usuario   = mysqli_fetch_assoc($resultado);

    if (!$usuario) return false;

    if (!password_verify($passwore, $usuario['passwore'])) return false;

    return $usuario;
}


// function email_existe(string $email): bool
// {
//     $conex = obtener_conexion();
//     $stmt  = mysqli_prepare($conex, "SELECT id FROM usuario WHERE email = ?");
//     mysqli_stmt_bind_param($stmt, "s", $email);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_store_result($stmt);
//     return mysqli_stmt_num_rows($stmt) > 0;
// }
