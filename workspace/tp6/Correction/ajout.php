<?php
// ajout.php - Ajout d'un film (admin seulement)
session_start();
require_once 'Auth.php';
Auth::requireLogin();
Auth::requireRole('admin');   // Devoir : acces reserve aux admins

require_once 'connexion.php';
require_once 'Film.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film = new Film(
        trim($_POST['titre']       ?? ''),
        trim($_POST['realisateur'] ?? ''),
        (int)   ($_POST['annee']   ?? 0),
        trim($_POST['genre']       ?? ''),
        (float) ($_POST['note']    ?? 0.0)
    );

    if ($film->save($pdo)) {
        header('Location: catalogue.php');
        exit;
    } else {
        $message = '<p style="color:red;">Erreur lors de l\'ajout.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film</title>
    <style>
        body  { font-family: Arial, sans-serif; max-width: 500px;
                margin: 40px auto; padding: 0 20px; }
        h2    { color: #0054a6; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 4px;
                        box-sizing: border-box; border: 1px solid #ccc;
                        border-radius: 4px; }
        button { margin-top: 16px; padding: 10px 20px;
                 background: #0054a6; color: white;
                 border: none; border-radius: 4px; cursor: pointer; }
        .back  { display: inline-block; margin-top: 10px; color: #0054a6; }
    </style>
</head>
<body>
    <h2>➕ Ajouter un film</h2>
    <?= $message ?>
    <form method="post">
        <label>Titre :
            <input type="text" name="titre" required>
        </label>
        <label>Réalisateur :
            <input type="text" name="realisateur" required>
        </label>
        <label>Année :
            <input type="number" name="annee" min="1888" max="2099" required>
        </label>
        <label>Genre :
            <input type="text" name="genre" required>
        </label>
        <label>Note (0.0 – 10.0) :
            <input type="number" name="note" step="0.1" min="0" max="10" required>
        </label>
        <button type="submit">Ajouter</button>
    </form>
    <a class="back" href="catalogue.php">← Retour au catalogue</a>
</body>
</html>
