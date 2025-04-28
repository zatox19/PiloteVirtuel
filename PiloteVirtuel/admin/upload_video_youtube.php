<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$file = __DIR__ . '/../data/videos_youtube.json';

// Créer le fichier s'il n'existe pas
if (!file_exists($file)) {
    file_put_contents($file, '[]');
}

// Charger les vidéos existantes
$videos = json_decode(file_get_contents($file), true);

// Si formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = trim($_POST['url']);
    $desc = trim($_POST['desc']);

    if (!empty($url) && !empty($desc)) {
        $videos[] = [
            'url' => $url,
            'desc' => $desc
        ];

        file_put_contents($file, json_encode($videos, JSON_PRETTY_PRINT));
        header('Location: manage-videos_youtube.php');
        exit;
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Vidéo YouTube</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>➕ Ajouter une Vidéo YouTube</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="url" placeholder="URL de la vidéo YouTube" required><br>
        <textarea name="desc" placeholder="Description de la vidéo" required></textarea><br>
        <button type="submit">Ajouter</button>
    </form>

    <a href="dashboard.php">⬅️ Retour au Dashboard</a>
</div>

</body>
</html>
