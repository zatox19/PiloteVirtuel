<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'secret') {
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php'); // Redirection après connexion
        exit;
    } else {
        $error = 'Identifiants incorrects.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion administrateur</title>
    <style>
        body { font-family: sans-serif; background-color: #f5f5f5; text-align: center; padding: 50px; }
        form { display: inline-block; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { display: block; margin: 10px auto; padding: 10px; width: 200px; }
        .error { color: red; }
    </style>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
    <?php if (isset($_GET['logout'])): ?>
    <p style="color: green; text-align: center;">✅ Vous avez bien été déconnecté.</p>
<?php endif; ?>

    <h1>Connexion</h1>
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Identifiant" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
