<?php 

include 'global.php';

$conexion = mysqli_connect(HOST,USER,PASSWORD);

if(mysqli_connect_errno()){
    echo "Fallo al conectar a la base de datos";
    exit();
}


?>