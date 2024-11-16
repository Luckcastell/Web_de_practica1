<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Manejo de la carga de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imagePath = 'uploads/' . basename($image['name']);

        // Mover el archivo subido a la carpeta 'uploads'
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Insertar en la base de datos
            $stmt = $pdo->prepare("INSERT INTO posts (title, image, description, user_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $imagePath, $description, $user_id]);

            header("Location: posts.php");
            exit;
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha subido ninguna imagen o ha ocurrido un error.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar</title>
    <link rel="stylesheet" href="publish.css">
</head>
<body>
<marquee behavior = "Alternate" scrolldelay = 40 truespeed><h1>------Publicar una nueva publicacion------</h1></marquee>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Título" required>
            <input type="file" name="image" accept="image/*" required>
            <textarea name="description" placeholder="Descripción" required></textarea>
            <div class="button-container">
                <button type="submit">Publicar</button>
                <button type="button" onclick="window.location.href='posts.php'">Ver Publicaciones</button>
            </div>
        </form>
    </div>
</body>
</html>