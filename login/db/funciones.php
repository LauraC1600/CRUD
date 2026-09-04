<?php

function obtener_conexion()
{
    global $conex;

    if (!isset($conex)) {
        require_once __DIR__ . '/conexion.php';
    }

    return $conex;
}

function email_existe(string $email): bool
{
    $conex = obtener_conexion();
    $stmt  = mysqli_prepare($conex, "SELECT id FROM usuario WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    return mysqli_stmt_num_rows($stmt) > 0;
}

function validar_usuario(string $email, string $passwore): array
{
    $errores = [];

    if (empty($email))          $errores[] = "El email es obligatorio.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    elseif (!email_existe($email)) $errores[] = "El email no está registrado.";

    if (empty($passwore))       $errores[] = "La contraseña es obligatoria.";

    return $errores;
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