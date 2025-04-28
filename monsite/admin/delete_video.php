<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = (int)$_POST['index'];
    $jsonPath = '../data/videos.json';

    if (file_exists($jsonPath)) {
        $videos = json_decode(file_get_contents($jsonPath), true);

        if (isset($videos[$index])) {
            $filename = '../videos/' . $videos[$index]['file'];

            // Supprimer le fichier video s’il existe
            if (file_exists($filename)) {
                unlink($filename);
            }

            // Supprimer l’entrée du JSON
            array_splice($videos, $index, 1);
            file_put_contents($jsonPath, json_encode($videos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}

header('Location: manage-videos.php');
exit;
