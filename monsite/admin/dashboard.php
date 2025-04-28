<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administration</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 30px;
        }
        a.button {
            display: block;
            margin: 15px auto;
            padding: 15px;
            width: 80%;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
        }
        a.button:hover {
            background-color: #555;
        }
    </style>
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body>

<div class="container">
    <h1>🎛 Dashboard Administration</h1>

    <a class="button" href="edit-page.php?page=../index.php">✏️ Modifier la page d'accueil</a>
    <a class="button" href="edit-page.php?page=../a-propos.php">✏️ Modifier la page À propos</a>
    <a class="button" href="edit-page.php?page=../contact.php">✏️ Modifier la page contact</a>
    <a class="button" href="delete_image.php">🖼️ Supprimer des images</a>
    <a class="button" href="delete_video.php">🎬 Supprimer des vidéos</a>
    <a class="button" href="upload_image.php">⬆️ Ajouter une Image</a>
    <a class="button" href="upload_video.php">⬆️ Ajouter une Vidéo</a>
    <a class="button" href="manage-videos_youtube.php">🎬 Supprimer les Vidéos YouTube/Vimeo/Dailymotion</a>
    <a class="button" href="upload_video_youtube.php">➕ Ajouter une Vidéo YouTube/Vimeo/Dailymotion</a>


    <a class="button" href="logout.php">🚪 Déconnexion</a>
</div>

</body>
</html>
