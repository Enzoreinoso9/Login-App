
<?php

//conexion a base de datos
include_once 'connection.php';



//verificación de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    



    // Verificar si el usuario existe en la tabla usuarios
    $sql = "SELECT id_usuario, username, contraseña FROM usuarios WHERE username = ?";
    
    $consulta = $conn->prepare($sql);
    
    if (!$consulta) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    
    $consulta->bind_param("s", $usuario);
    
    $consulta->execute();
    
    $resultado = $consulta->get_result();
    


    
    //verificar si se encontro el usuario
    if ($resultado->num_rows == 1) {


        //obtener fila como un array asociativo
        $fila = $resultado->fetch_assoc();
        

        //verificar la contraseña
        if (password_verify($contraseña, $fila['contraseña'])) {



            //inicio de sesion 
            session_start();
            $_SESSION['usuario_id'] = $fila['id_usuario'];
            $_SESSION['username'] = $fila['username'];
            
            header("Location: main.php");
            exit();
        } else {
            echo "Contraseña incorrecta. <a href='login.html'>Volver al inicio de sesión</a>";
        }
    } else {
        echo "Usuario no encontrado. <a href='login.html'>Volver al inicio de sesión</a> o <a href='registro.html'>Registrarse</a>";
    }
    
    $consulta->close();
}


//cerrar conexión base de datos
$conn->close();
?>
