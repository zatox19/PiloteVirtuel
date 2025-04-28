<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['page'])) {
    echo "❌ Paramètre 'page' manquant.";
    exit;
}

$page = $_GET['page'];

// Protection basique contre accès interdits
$page = str_replace(['..', '/', '\\'], '', $page);



echo "<pre>Page demandée: " . htmlspecialchars($page) . "\n";
echo "Chemin trouvé: " . htmlspecialchars($pagePath) . "</pre>";






// Exemple : si tu passes ?page=index.php
$pagePath = realpath(__DIR__ . '/../' . $page);

if ($pagePath === false || strpos($pagePath, realpath(__DIR__ . '/../')) !== 0) {
    echo "❌ Fichier invalide.";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveauContenu = $_POST['contenu'] ?? '';

    if (strpos($nouveauContenu, '<?php') !== false) {
        $message = "❌ Le code PHP n'est pas autorisé ici.";
    } else {
        file_put_contents($pagePath, $nouveauContenu);
        $message = "✅ Page mise à jour avec succès.";
    }
}

$contenuActuel = file_exists($pagePath) ? file_get_contents($pagePath) : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            text-align: center;
            padding: 40px;
        }
        form {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        textarea {
            width: 100%;
            height: 600px;
            font-family: monospace;
            font-size: 14px;
            margin-top: 10px;
        }
        button {
            margin-top: 20px;
            padding: 10px 25px;
            background: #333;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        a {
            display: block;
            margin-top: 30px;
            text-decoration: none;
            color: #333;
        }
        p.message {
            color: green;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<h1>🛠 Modifier la page</h1>

<?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <textarea name="contenu" id="editor"><?= htmlspecialchars($contenuActuel) ?></textarea>
    <br>
    <button type="submit">💾 Enregistrer</button>
</form>

<a href="dashboard.php">⬅️ Retour au Dashboard</a>

<!-- CKEditor avec rendu WYSIWYG -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        allowedContent: true,
        fullPage: true,
        extraPlugins: 'wysiwygarea'
    });
</script>

</body>
</html>
