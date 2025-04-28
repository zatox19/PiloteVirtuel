<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contactez l'artisan pour plus d'informations">
    <title>Contact</title>
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 0; }
        header { background: #333; color: white; padding: 20px 0; text-align: center; }
        h1 { color: #3498db; }
        nav { text-align: center; background: #444; padding: 10px; }
        nav a { color: white; margin: 0 20px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        section { padding: 40px 20px; text-align: center; }
        .contact-info { margin-top: 20px; font-size: 18px; }
        footer { text-align: center; padding: 10px 0; background: #333; color: white; }
    </style>
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>

<header>
    <h1>Contactez-moi</h1>
</header>

<?php include('menu.php'); ?>

<section>
    <h2>Mes coordonnées</h2>

    <p>Robert DELORD</p>

    <div class="contact-info">
        <p>📍 Adresse : 24, rue du puy Marlot, 19230 Arnac-Pompadour</p>
        <p>📞 Téléphone : 06 16 46 58 54</p>
        <p>✉️ Email : <a href="mailto:r.delord@gmail.com">r.delord@gmail.com</a></p>
    </div>
</section>

<footer>
    <p>&copy; 2025 Robert DELORD - Artisan</p>
</footer>

</body>
</html>
