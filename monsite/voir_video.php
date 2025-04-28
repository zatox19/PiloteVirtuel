<?php
// Vérifie que le paramètre 'file' est passé
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $file = basename($_GET['file']); // Sécurise le nom du fichier
    $videoPath = 'videos/' . $file;

    if (file_exists($videoPath)) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Voir la vidéo</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                }
                video {
                    max-width: 80%;
                    height: auto;
                    box-shadow: 0 0 20px rgba(0,0,0,0.2);
                    border-radius: 10px;
                }
                .back-link {
                    margin-top: 20px;
                    text-decoration: none;
                    background-color: #444;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 8px;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                }
                .back-link:hover {
                    background-color: #666;
                }
            </style>
            <link href="css/style.css" rel="stylesheet" />

        </head>
        <body>

            <video controls>
                <source src="<?php echo htmlspecialchars($videoPath); ?>" type="video/mp4">
                Votre navigateur ne prend pas en charge la lecture vidéo.
            </video>

            <a href="videos.php" class="back-link">
                🔙 Retour aux vidéos
            </a>

        </body>
        </html>
        <?php
    } else {
        echo "<p>❌ Vidéo non trouvée.</p>";
    }
} else {
    echo "<p>❌ Paramètre 'file' manquant.</p>";
}
?>
