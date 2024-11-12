<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO ratings (post_id, user_id, rating) VALUES (?, ?, ?)");
    $stmt->execute([$post_id, $user_id, $rating]);

    header("Location: posts.php");
}
?>