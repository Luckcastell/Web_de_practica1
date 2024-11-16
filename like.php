<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Contar la cantidad de interacciones del usuario con esta publicación
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    $like_count = $stmt->fetchColumn();

    if ($like_count < 5) { // Verificar si el usuario ya ha dado like/dislike menos de 5 veces
        if (isset($_POST['like'])) {
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id, liked) VALUES (?, ?, 1)");
            $stmt->execute([$post_id, $user_id]);
        } elseif (isset($_POST['dislike'])) {
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id, liked) VALUES (?, ?, 0)");
            $stmt->execute([$post_id, $user_id]);
        }
    } else {
        // Aquí puedes manejar el caso cuando el usuario ya ha alcanzado el límite
        echo "Has alcanzado el límite de 5 interacciones con esta publicación.";
        // Redireccionar o mostrar un mensaje adecuado
        header("Location: posts.php");
        exit;
    }

    // Redirigir a la URL almacenada en la sesión
    if (isset($_SESSION['current_url'])) {
        header("Location: " . $_SESSION['current_url']);
    } else {
        // Si no hay URL almacenada, redirigir a posts.php por defecto
        header("Location: posts.php");
    }
    exit;
}
?>