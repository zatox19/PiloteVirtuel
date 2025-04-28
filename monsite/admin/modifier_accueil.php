<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$accueilPath = '../index.php';
$message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveauContenu = $_POST['contenu'] ?? '';

    // Protection de base : empêcher certaines balises PHP d'être insérées
    if (strpos($nouveauContenu, '<?php') !== false) {
        $message = "❌ Le code PHP n'est pas autorisé ici.";
    } else {
        file_put_contents($accueilPath, $nouveauContenu);
        $message = "✅ Page d'accueil mise à jour avec succès.";
    }
}

// Chargement du contenu actuel
$contenuActuel = file_exists($accueilPath) ? file_get_contents($accueilPath) : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la page d'accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
            text-align: center;
        }
        form {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        textarea {
            width: 100%;
            height: 500px;
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
        p.message {
            color: green;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

    <h1>🛠 Modifier la page d'accueil</h1>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <textarea name="contenu"><?= htmlspecialchars($contenuActuel) ?></textarea>
        <br>
        <button type="submit">💾 Enregistrer</button>
    </form>

    <a href="dashboard.php">⬅️ Retour au dashboard</a>

</body>
</html>
