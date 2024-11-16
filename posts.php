<?php
session_start(); // Esto debe estar al principio del archivo

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Es recomendable usar exit() después de header para detener la ejecución del script
}
include 'db.php';

// Obtener las publicaciones de la base de datos junto con los conteos de likes y dislikes
$stmt = $pdo->query("
    SELECT p.*, 
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND liked = 1) AS like_count,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND liked = 0) AS dislike_count
    FROM posts p
");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones</title>
    <link rel="stylesheet" href="post.css">
</head>
<body>
    <marquee behavior = "Alternate" scrolldelay = 40 truespeed><h1>------Publicaciones------</h1></marquee>
    <center><div class="button-container">
        <a class="button" href="publish.php">Subir nueva publicación</a>
        <a class="button" href="logout.php">Cerrar Sesión</a>
    </div></center>
    <div class="container">
        <div class="posts">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Imagen de publicación">
                    <p><?php echo htmlspecialchars($post['description']); ?></p>
                    <div class="button-container">
                        <form method="POST" action="rate.php">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <input type="number" name="rating" min="1" max="10" required>
                            <button type="submit">Califica con ⭐ estrellas</button>
                        </form>
                        <form method="POST" action="like.php">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" name="like">👍 Likes: <?php echo $post['like_count']; ?></button>
                            <button type="submit" name="dislike">👎 Dislikes: <?php echo $post['dislike_count']; ?></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Guardar la posición de desplazamiento al cargar la página
        window.onload = function() {
            if (localStorage.getItem('scrollPosition')) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
            }
        };

        // Guardar la posición de desplazamiento antes de salir de la página
        window.onbeforeunload = function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        };
    </script>
</body>
</html>