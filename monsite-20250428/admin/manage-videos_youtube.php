<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$file = __DIR__ . '/../data/videos_youtube.json';

if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

$json = file_get_contents($file);
$videos = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $url = trim($_POST['url']);
        $desc = trim($_POST['desc']);
        if ($url && $desc) {
            $videos[] = ['url' => $url, 'desc' => $desc];
            file_put_contents($file, json_encode($videos, JSON_PRETTY_PRINT));
            header('Location: manage-videos_youtube.php');
            exit;
        }
    } elseif (isset($_POST['delete'])) {
        $index = intval($_POST['delete']);
        if (isset($videos[$index])) {
            array_splice($videos, $index, 1);
            file_put_contents($file, json_encode($videos, JSON_PRETTY_PRINT));
            header('Location: manage-videos_youtube.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les vidéos YouTube</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        form {
            margin-bottom: 30px;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<header>
    <h1>🛠 Gérer les vidéos YouTube</h1>
</header>

<div class="container">
    <form method="post">
        <input type="text" name="url" placeholder="Lien YouTube (embed URL)" required><br>
        <input type="text" name="desc" placeholder="Description" required><br>
        <button type="submit" name="add">Ajouter une vidéo</button>
    </form>

    <h2>Vidéos existantes :</h2>
    <ul>
        <?php foreach ($videos as $index => $video): ?>
            <li>
                <?php echo htmlspecialchars($video['desc']); ?>
                (<a href="<?php echo htmlspecialchars($video['url']); ?>" target="_blank">Voir</a>)
                <form method="post" style="display:inline;">
                    <button type="submit" name="delete" value="<?php echo $index; ?>">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <br><a href="dashboard.php">🔙 Retour au Dashboard</a>
</div>

</body>
</html>
