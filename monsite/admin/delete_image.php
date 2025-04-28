<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = (int)$_POST['index'];
    $jsonPath = '../data/images.json';

    if (file_exists($jsonPath)) {
        $images = json_decode(file_get_contents($jsonPath), true);

        if (isset($images[$index])) {
            $filename = '../images/' . $images[$index]['image'];

            // Supprimer le fichier image s’il existe
            if (file_exists($filename)) {
                unlink($filename);
            }

            // Supprimer l’entrée du JSON
            array_splice($images, $index, 1);
            file_put_contents($jsonPath, json_encode($images, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}

header('Location: manage-images.php');
exit;
