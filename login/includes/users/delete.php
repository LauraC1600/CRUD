<?php
require_once __DIR__ . '/get.php';

session_start();
if (empty($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}


function delete_user(int $id): bool
{
    $conex = obtener_conexion();


    $sql = "DELETE FROM usuario WHERE id = $id;";


    return mysqli_query($conex, $sql);
}


$id = isset($_GET['status']) ? (int) $_GET['status'] : 0;



if(delete_user($id)){
    header('Location: ../../pag/users.php?status=4');

}else{
    header('Location: ../../pag/users.php?status=5');
}