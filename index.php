<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Artagram</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido a Artagram</h1>
        <p>¡Hola, usuario gracias por venir!</p>
        <p>Esta es una plataforma para compartir tu arte sin miedo al heate y poder expresar tu gusto por el arte de los demas.</p>
        
        <div class="button-container">
            <a class="button" href="posts.php">Ver Publicaciones</a>
            <a class="button" href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>