<?php

$hostName = "localhost";
$userName = "root";
$password = "1234";
$database = "Ejemplo";

$conex = mysqli_connect($hostName, $userName, $password, $database);

if (!$conex) {
    echo "Conexión fallida: ";
}
