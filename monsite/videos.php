<?php
// Suppression d'une vidéo si besoin (hors site public normalement)
if (isset($_GET['delete'])) {
    $video_to_delete = $_GET['delete'];
    $videos = json_decode(file_get_contents('data/videos.json'), true);

    foreach ($videos as $key => $video) {
        if ($video['video'] === $video_to_delete) {
            unlink("videos/" . $video_to_delete); // supprimer le fichier vidéo
            unset($videos[$key]); // supprimer du tableau
            file_put_contents('data/videos.json', json_encode(array_values($videos), JSON_PRETTY_PRINT));
            break;
        }
    }

    // Rediriger pour éviter la suppression multiple si on recharge la page
    header("Location: videos.php");
    exit();
}

// Charger la liste des vidéos
$jsonPath = 'data/videos.json';
$videos = [];

if (file_exists($jsonPath)) {
    $videos = json_decode(file_get_contents($jsonPath), true);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <meta name="description" content="Vidéos du site">
    <title>Vidéos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 0; }
        header { background: #333; color: white; padding: 20px 0; text-align: center; }
        nav { text-align: center; background: #444; padding: 10px; }
        nav a { color: white; margin: 0 20px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        .video-gallery { display: flex; flex-wrap: wrap; justify-content: center; padding: 20px; gap: 20px; }
        .video-item { max-width: 320px; text-align: center; background: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        video { width: 100%; height: auto; border-radius: 6px; }
        footer { text-align: center; padding: 10px 0; background: #333; color: white; }
    </style>
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>
    <header>
        <h1>Mes vidéos</h1>
    </header>

    <?php include('menu.php'); ?>

    <section class="video-gallery">
    <h2>Quelques-unes de mes vidéos</h2>
    <?php foreach ($videos as $video): ?>
        <div class="video-item">
            <!-- Lien vers la page pour visualiser la vidéo -->
            <!--<a href="voir_video.php?file=<?= urlencode($video['video']) ?>"> -->
            <a href="voir_video.php?file=<?= urlencode($video['file']) ?>">

                <img src="assets/video-placeholder.jpg" alt="Miniature vidéo" width="300">
            </a>
            <p><?= htmlspecialchars($video['desc']) ?></p>
        </div>
    <?php endforeach; ?>
    </section>

    <footer>
        <p>&copy; 2025 Ton Nom - Artisan</p>
    </footer>
</body>
</html>
