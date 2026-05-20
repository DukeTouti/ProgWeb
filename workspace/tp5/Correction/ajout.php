<?php
require_once 'Film.php';
require_once 'connexion.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $film = new Film(
        $_POST['titre'],
        $_POST['realisateur'],
        (int)$_POST['annee'],
        $_POST['genre'],
        (float)$_POST['note']
    );

    $pdo = getConnexion();
    $resultat = $film->save($pdo);

    $message = $resultat ? 'Film ajouté avec succès.' : 'Erreur lors de l\'ajout du film.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film</title>
</head>
<body>
    <h2>Ajouter un film</h2>
    <?= $message ?>
    <form method="post", action="ajout.php">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required><br>

        <label for="realisateur">Réalisateur :</label>
        <input type="text" name="realisateur" required><br>

        <label for="annee">Année :</label>
        <input type="number" name="annee" min="1888" max="2099" required><br>

        <label for="genre">Genre :</label>
        <select name="genre" required>
            <option value="">--Sélectionnez un genre--</option>
            <option value="Action">Action</option>
            <option value="Comédie">Comédie</option>
            <option value="Drame">Drame</option>
            <option value="Science-fiction">Science-fiction</option>
            <option value="Horreur">Horreur</option>
        </select><br>

        <label for="note">Note :</label>
        <input type="number" step="0.1" name="note" min="0" max="10" required><br>

        <button type="submit">Ajouter</button>
        <a href="catalogue.php">Retour au catalogue</a>
    </form>
</body>
</html>