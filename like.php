<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['like'])) {
        $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id, liked) VALUES (?, ?, 1)");
        $stmt->execute([$post_id, $user_id]);
    } elseif (isset($_POST['dislike'])) {
        $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id, liked) VALUES (?, ?, 0)");
        $stmt->execute([$post_id, $user_id]);
    }

    header("Location: posts.php");
}
?>