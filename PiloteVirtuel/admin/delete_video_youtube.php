<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$file = __DIR__ . '/../data/videos_youtube.json';

// Vérifie si le fichier existe
if (!file_exists($file)) {
    echo "❌ Le fichier videos_youtube.json est introuvable.";
    exit;
}

// Récupère les données du fichier JSON
$json = file_get_contents($file);
$videos = json_decode($json, true);
if (!$videos) {
    echo "❌ Erreur lors du décodage du JSON.";
    exit;
}

// Vérifie si une vidéo doit être supprimée
if (isset($_GET['id'])) {
    $video_id = $_GET['id'];
    $video_found = false;

    // Cherche la vidéo à supprimer
    foreach ($videos as $index => $video) {
        if ($video['id'] == $video_id) {
            // Supprime la vidéo du tableau
            unset($videos[$index]);
            $video_found = true;
            break;
        }
    }

    // Si la vidéo est trouvée, met à jour le fichier JSON
    if ($video_found) {
        // Réindexe le tableau pour éviter les clés manquantes
        $videos = array_values($videos);

        // Sauvegarde les modifications dans le fichier JSON
        file_put_contents($file, json_encode($videos, JSON_PRETTY_PRINT));

        header("Location: manage-videos_youtube.php?success=1");
        exit;
    } else {
        echo "❌ Vidéo introuvable.";
    }
} else {
    echo "❌ Aucun ID de vidéo spécifié.";
}
?>
