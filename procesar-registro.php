<?php 

//Conexión a base de datos
include_once 'connection.php';



//definicion de variables
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$username = $_POST['username'];
$contraseña = $_POST['contraseña'];
$correo = $_POST['correo'];
$fechaNacimiento = $_POST['fechaNacimiento'];



//Validación de los datos
if (empty($nombres) || empty($apellidos) || empty($username) || empty($contraseña) || empty($correo) || empty($fechaNacimiento)) {
    echo "Todos los campos son obligatorios.";
    exit();
}


//hash de la contraseña
$hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);


//consulta sql para ingresar a la tabla registro
$sql = "INSERT INTO registro (nombres, apellidos, correo, fechaNacimiento) VALUES (?, ?, ?, ?)";


//preparar consulta
$consulta = $conn->prepare($sql);

if (!$consulta) {
    die("Error al preparar la consulta: " . $conn->error);
}

//enlazar parametros
$consulta->bind_param("ssss", $nombres, $apellidos, $correo, $fechaNacimiento);



//ejecutar consulta
if ($consulta->execute()) {
    $id_registro = $consulta->insert_id;


//consulta sql para la tabla usuarios
    $sql = "INSERT INTO usuarios (username, contraseña, id_registro) VALUES (?, ?, ?)";
    



//preparar, enlazar parametros y ejecutar para la tabla usuarios
    $consulta = $conn->prepare($sql);
    
    if (!$consulta) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    


    $consulta->bind_param("ssi", $username, $hashedPassword, $id_registro);
    


    if ($consulta->execute()) {
        echo "Registro exitoso. ¡Bienvenido!";
        header("Location: main.php");
        exit();
    } else {
        echo "Error al registrar el usuario: " . $consulta->error;
    }
} else {
    echo "Error al registrar el usuario: " . $consulta->error;
}



//cerrar consulta
$consulta->close();


//cerrar conexion base de datos
$conn->close();
?>
