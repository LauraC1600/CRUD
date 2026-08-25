<?php


$hostName = "localhost";
$userName = "root";
$password = "1234";
$database = "Ejemplo";

$conex = mysqli_connect($hostName, $userName, $password, $database);

echo '<pre>';

if($conex){
    echo "conexion exitosa";
}

if(!$conex){
    echo "conexion fallida";
    exit;
}
