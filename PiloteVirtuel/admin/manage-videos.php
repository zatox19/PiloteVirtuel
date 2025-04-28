<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$videos = json_decode(file_get_contents('../data/videos.json'), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les videos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .video-block {
            display: inline-block;
            margin: 15px;
            padding: 15px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        img {
            max-width: 200px;
            border-radius: 8px;
        }
        .desc {
            margin-top: 10px;
            font-weight: bold;
        }
        button {
            margin-top: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c0392b;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <h1>🖼 Gérer les videos</h1>
    <?php foreach ($videos as $index => $img): ?>
        <div class="video-block">
            <img src="../videos/<?= htmlspecialchars($img['file']) ?>" alt="video">
            <div class="desc"><?= htmlspecialchars($img['desc']) ?></div>
            <form method="POST" action="delete_video.php" onsubmit="return confirm('Supprimer cette video ?');">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit">🗑 Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
<div style="text-align: center; margin: 20px;">
    <a href="dashboard.php" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #444; color: white; border: none; border-radius: 6px; cursor: pointer;">
            ⬅️ Retour au dashboard
        </button>
    </a>
</div>

