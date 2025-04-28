<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $type = mime_content_type($_FILES['image']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($type, $allowedTypes)) {
            echo "❌ Format de fichier non autorisé. <a href='dashboard.php'>Retour</a>";
            exit;
        }

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'img_' . uniqid() . '.' . $extension;
        $destination = '../images/' . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $desc = htmlspecialchars($_POST['desc'] ?? '');
            $jsonPath = '../data/images.json';

            if (!file_exists($jsonPath)) {
                file_put_contents($jsonPath, json_encode([]));
            }

            $images = json_decode(file_get_contents($jsonPath), true);
            $images[] = ['image' => $filename, 'desc' => $desc];
            file_put_contents($jsonPath, json_encode($images, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            echo "✅ Image envoyée avec succès. <a href='dashboard.php'>Retour</a>";
        } else {
            echo "❌ Erreur lors de l'envoi du fichier.";
        }
    } else {
        echo "❌ Aucun fichier reçu.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uploader une image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding-top: 100px;
        }

        form {
            display: inline-block;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .custom-file-upload {
            display: block;
            position: relative;
            cursor: pointer;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin: 15px auto;
            width: 100%;
            text-align: center;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        #fileName {
            font-style: italic;
            color: #555;
        }

        input[type="text"], input[type="submit"] {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

    <form action="upload_image.php" method="post" enctype="multipart/form-data">
        <h2>Uploader une image</h2>

        <label class="custom-file-upload">
            <input type="file" name="image" id="fileInput" required>
            <span id="fileName">📎 Aucun fichier sélectionné</span>
        </label>

        <input type="text" name="desc" placeholder="Description de l’image" required>
        <input type="submit" value="Envoyer">
    </form>

    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : "📎 Aucun fichier sélectionné";
            document.getElementById('fileName').textContent = fileName;
        });
    </script>
    <div style="text-align: center; margin-top: 20px;">
    <a href="dashboard.php" style="text-decoration: none; color: #444; font-weight: bold;">
        ⬅️ Retour au dashboard
    </a>
</div>


</body>
</html>
