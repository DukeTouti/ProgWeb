<?php
// modifierFilm.php - Modification d'un film (admin seulement)
session_start();
require_once 'Auth.php';
Auth::requireLogin();
Auth::requireRole('admin');

require_once 'connexion.php';
require_once 'Film.php';

$id   = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$film = (new Film('', '', 0, '', 0.0))->findById($pdo, $id);

if (!$film) {
    echo "<p style='color:red;'>Film introuvable (id=$id).</p>";
    echo "<a href='catalogue.php'>← Retour</a>";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film->setTitre(      trim($_POST['titre']       ?? ''));
    $film->setRealisateur(trim($_POST['realisateur'] ?? ''));
    $film->setAnnee(      (int)   ($_POST['annee']   ?? 0));
    $film->setGenre(      trim($_POST['genre']       ?? ''));
    $film->setNote(       (float) ($_POST['note']    ?? 0.0));

    if ($film->update($pdo)) {
        header('Location: catalogue.php');
        exit;
    } else {
        $message = '<p style="color:red;">Erreur lors de la mise à jour.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un film</title>
    <style>
        body  { font-family: Arial, sans-serif; max-width: 500px;
                margin: 40px auto; padding: 0 20px; }
        h2    { color: #0054a6; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input  { width: 100%; padding: 8px; margin-top: 4px;
                 box-sizing: border-box; border: 1px solid #ccc;
                 border-radius: 4px; }
        button { margin-top: 16px; padding: 10px 20px;
                 background: #0054a6; color: white;
                 border: none; border-radius: 4px; cursor: pointer; }
        .back  { display: inline-block; margin-top: 10px; color: #0054a6; }
    </style>
</head>
<body>
    <h2>✏️ Modifier – <?= htmlspecialchars($film->getTitre()) ?></h2>
    <?= $message ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $film->getId() ?>">

        <label>Titre :
            <input type="text" name="titre"
                   value="<?= htmlspecialchars($film->getTitre()) ?>" required>
        </label>
        <label>Réalisateur :
            <input type="text" name="realisateur"
                   value="<?= htmlspecialchars($film->getRealisateur()) ?>" required>
        </label>
        <label>Année :
            <input type="number" name="annee" min="1888" max="2099"
                   value="<?= $film->getAnnee() ?>" required>
        </label>
        <label>Genre :
            <input type="text" name="genre"
                   value="<?= htmlspecialchars($film->getGenre()) ?>" required>
        </label>
        <label>Note (0.0 – 10.0) :
            <input type="number" name="note" step="0.1" min="0" max="10"
                   value="<?= $film->getNote() ?>" required>
        </label>
        <button type="submit">Enregistrer</button>
    </form>
    <a class="back" href="catalogue.php">← Retour au catalogue</a>
</body>
</html>
