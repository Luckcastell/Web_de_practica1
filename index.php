<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Mi Aplicación</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenido a Mi Aplicación</h1>
    <p>Esta es una plataforma para compartir y calificar publicaciones.</p>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>¡Hola, usuario!</p>
        <a href="posts.php">Ver Publicaciones</a>
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <p>Por favor, inicia sesión o regístrate para comenzar.</p>
        <a href="login.php">Iniciar Sesión</a>
        <a href="register.php">Registrar</a>
    <?php endif; ?>
</body>
</html>