<?php
$file = __DIR__ . '/data/images.json';

if (!file_exists($file)) {
    echo "❌ Le fichier images.json est introuvable.";
    exit;
}

$json = file_get_contents($file);
$images = json_decode($json, true);
if (!$images) {
    echo "❌ Erreur lors du décodage du JSON.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>images</title>
    <link href="css/style.css" rel="stylesheet" />

</head>
<body>

<header>
    <h1>Ma images</h1>
</header>

<?php include('menu.php'); ?>

<section class="gallery">
<?php $i = 0; ?>
<?php foreach ($images as $item): ?>
        <div class="gallery-item" style="--i: <?php echo $i++; ?>">
    <a href="#lightbox" onclick="openLightbox('images/<?php echo htmlspecialchars($item['image']); ?>')">
        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="">
    </a>
    <p><?php echo htmlspecialchars($item['desc']); ?></p>
</div>

    <?php endforeach; ?>
</section>

<footer>
    <p>&copy; 2025 Ton Nom - Artisan</p>
</footer>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" src="" alt="">
</div>

<script>
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}
</script>


</body>
</html>
