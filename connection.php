<?php 

//Configuración de la conexión a la database

$host="localhost";
$username="root";
$password="";
$database= "base_login";



//Establecer conexión

$conn = new mysqli($host,$username,$password,$database);



//Verificar conexión

if (!$conn) {
    die("Conexión Fallida: ". $conn->connect_error);
}


?>