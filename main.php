<?php


session_start();



//verificar usuario
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}


//conexion a la base de datos
include_once 'connection.php';



//obtener ID de usuario
$usuario_id = $_SESSION['usuario_id'];




//consutar sql para obtener los datos del usuario
$sql = "SELECT r.nombres, r.apellidos, r.correo, r.fechaNacimiento FROM registro r INNER JOIN usuarios u ON r.id_registro = u.id_registro WHERE u.id_usuario = ?";

$consulta = $conn->prepare($sql);
$consulta->bind_param("i", $usuario_id);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();
    $nombres = $usuario['nombres'];
    $apellidos = $usuario['apellidos'];
    $correo = $usuario['correo'];
    $fechaNacimiento = $usuario['fechaNacimiento'];
}

$consulta->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>

<header>

<h1>¡BIENVENIDO!</h1>

</header>

<nav>
<a href="#">Home</a>
<a href="#">Noticias</a>
<a href="#">Contacto</a>
<a href="#">Sobre mi</a>
<a href="cerrar-sesion.php">Cerrar Sesión</a>
</nav>

<div class="row">

<aside>
    <h2>Aside</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit id ipsa ullam sed officiis. Cumque deserunt ullam dolorum maiores maxime tenetur aperiam fugiat exercitationem, officiis vero et blanditiis facere dolores!</p>
</aside>
<section>
    <h2>Section</h2>
    <h3>Información de tu perfil:</h3>

    <p> <span class="infousuario">Nombre</span>:  <?php echo $nombres; ?>.</p>
    <p> <span class="infousuario">Apellidos</span>: <?php echo $apellidos; ?>.</p>
    <p> <span class="infousuario">Correo</span>: <?php echo $correo; ?>.</p>
    <p> <span class="infousuario">Fecha de Nacimiento</span>: <?php echo $fechaNacimiento; ?>.</p>

</section>
</div>

<footer>

<h2 class="text">Footer</h2>
<p class="text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia aspernatur minus repellat atque quis non explicabo est perferendis, iusto minima odio. Natus dolorem ut eligendi facere cum nesciunt incidunt doloremque</p>

</footer>


</body>
</html>