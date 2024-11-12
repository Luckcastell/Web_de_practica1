<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, image, description, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $image, $description, $user_id]);

    header("Location: posts.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Publicar una Nueva Publicación</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="image" placeholder="URL de la Imagen" required>
        <textarea name="description" placeholder="Descripción" required></textarea>
        <button type="submit">Publicar</button>
    </form>
    <a href="posts.php">Ver Publicaciones</a>
</body>
</html>