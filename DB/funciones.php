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

function insert_usuario(string $name, string $last_name): bool {
    try {
        require './DB/conexion.php';

        $name      = mysqli_real_escape_string($conex, $name);
        $last_name = mysqli_real_escape_string($conex, $last_name);

        $sql = "INSERT INTO USUARIO (name, last_name) VALUES ('$name', '$last_name')";

        return mysqli_query($conex, $sql);

    } catch (\Throwable $th) {
        var_dump($th);
        return false;
    }
}