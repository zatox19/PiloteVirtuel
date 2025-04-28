<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($finfo, $_FILES['video']['tmp_name']);
        finfo_close($finfo);

        $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/x-matroska'];

        if (!in_array($type, $allowedTypes)) {
            echo "❌ Format de fichier non autorisé. Type détecté : $type";
            exit;
        }

        $extension = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $tempFile = $_FILES['video']['tmp_name'];
        $newFilename = 'vid_' . uniqid();
        $destinationDir = '../videos';

        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0777, true);
        }

        // Si c'est un MKV → conversion en MP4
        if ($type === 'video/x-matroska' || $extension === 'mkv') {
            $finalFilename = $newFilename . '.mp4';
            $outputPath = $destinationDir . '/' . $finalFilename;

            $cmd = "ffmpeg -i " . escapeshellarg($tempFile) . " -c:v libx264 -c:a aac -strict experimental " . escapeshellarg($outputPath) . " 2>&1";
            exec($cmd, $output, $returnCode);

            if ($returnCode !== 0) {
                echo "❌ Erreur lors de la conversion du fichier MKV en MP4.";
                echo "<pre>" . implode("\n", $output) . "</pre>";
                exit;
            }

        } else {
            // Pas besoin de conversion
            $finalFilename = $newFilename . '.' . $extension;
            $outputPath = $destinationDir . '/' . $finalFilename;
            if (!move_uploaded_file($tempFile, $outputPath)) {
                echo "❌ Erreur lors de la copie du fichier.";
                exit;
            }
        }

        // Enregistrement dans videos.json
        $desc = htmlspecialchars($_POST['desc'] ?? '');
        $jsonPath = '../data/videos.json';

        if (!file_exists($jsonPath)) {
            file_put_contents($jsonPath, json_encode([]));
        }

        $videos = json_decode(file_get_contents($jsonPath), true);
        $videos[] = ['file' => $finalFilename, 'desc' => $desc];
        file_put_contents($jsonPath, json_encode($videos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo "✅ Vidéo envoyée avec succès. <a href='dashboard.php'>Retour</a>";
        exit;

    } else {
        echo "❌ Aucun fichier reçu.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uploader une vidéo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 80px;
            background-color: #f8f8f8;
        }
        form {
            background-color: white;
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="file"], input[type="text"] {
            display: block;
            margin: 10px auto;
        }
        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        a {
            display: block;
            margin-top: 20px;
            color: #444;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

    <h1>Uploader une vidéo</h1>
    <form action="upload_video.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="video" accept="video/*" required>
        <input type="text" name="desc" placeholder="Description (facultatif)">
        <button type="submit">Envoyer</button>
    </form>

    <a href="dashboard.php">⬅️ Retour au dashboard</a>

</body>
</html>
