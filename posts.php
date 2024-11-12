<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Publicaciones</h2>
    <a href="publish.php">Crear Nueva Publicación</a>
    <div class="posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Imagen de publicación">
                <p><?php echo htmlspecialchars($post['description']); ?></p>
                
                <form method="POST" action="rate.php">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <label>Califica (1-10):</label>
                    <input type="number" name="rating" min="1" max="10" required>
                    <button type="submit">Calificar</button>
                </form>

                <form method="POST" action="like.php">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <button type="submit" name="like">👍 Like</button>
                    <button type="submit" name="dislike">👎 Dislike</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>