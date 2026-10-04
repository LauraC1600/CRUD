<?php

session_start();

$_SESSION['usuario_id']    = [];
$_SESSION['usuario_email'] = [];

header('Location:  ../index.php');
