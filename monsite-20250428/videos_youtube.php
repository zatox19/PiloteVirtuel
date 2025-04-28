<?php
$file = __DIR__ . '/data/videos_youtube.json';

if (!file_exists($file)) {
    echo "❌ Le fichier videos_youtube.json est introuvable.";
    exit;
}

$json = file_get_contents($file);
$videos = json_decode($json, true);
if (!$videos) {
    echo "❌ Erreur lors du décodage du JSON.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vidéos YouTube</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>

<header>
    <h1>🎥 Vidéos YouTube</h1>
</header>

<?php include('menu.php'); ?>

<section class="gallery">
    <?php foreach ($videos as $video): ?>
        <div class="gallery-item">
            <?php
            // Extraction de l'ID de la vidéo YouTube
            preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video['url'], $matches);
            if (isset($matches[1])) {
                $video_id = $matches[1];
                // Création de l'URL d'intégration de la vidéo
                $embed_url = "https://www.youtube.com/embed/" . $video_id;
            } else {
                $embed_url = $video['url']; // Si l'URL ne correspond pas à YouTube, on l'affiche telle quelle
            }
            ?>
            <iframe width="300" height="200" src="<?php echo htmlspecialchars($embed_url); ?>" frameborder="0" allowfullscreen></iframe>
            <p><?php echo htmlspecialchars($video['desc']); ?></p>
        </div>
    <?php endforeach; ?>
</section>

<footer>
    <p>&copy; 2025 Ton Nom - Artisan</p>
</footer>

</body>
</html>
