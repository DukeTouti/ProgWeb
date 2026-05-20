<?php
require_once 'Film.php';
require_once 'connexion.php';

$pdo = getConnexion();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Traitement POST : mise a jour du film
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $film = Film::findById($pdo, $id);

    if ($film === null) {
        $erreur = 'Film introuvable';
    } else {
        $film->setTitre($_POST['titre']);
        $film->setRealisateur($_POST['realisateur']);
        $film->setAnnee((int)$_POST['annee']);
        $film->setGenre($_POST['genre']);
        $film->setNote((float)$_POST['note']);

        if ($film->update($pdo)) {
            header('Location: catalogue.php');
            exit;
        } else {
            $erreur = 'Erreur lors de la mise à jour du film';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un film</title>
</head>
<body>
    <h2>Modifier un film</h2>

    <?php if (isset($erreur)): ?>
        <p style="color: red;"><?php echo $erreur; ?></p>
    <?php endif; ?>

    <form method="post" action="modifierFilm.php">
        <input type="hidden" name="id"><br>
        
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>
        
            <label for="realisateur">Réalisateur :</label>
            <input type="text" id="realisateur" name="realisateur" required>
        
            <label for="annee">Année :</label>
            <input type="number" id="annee" name="annee" required>
        
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
            <input type="number" id="note" name="note" step="0.1" min="0" max="10" required>
        
        <button type="submit">Mettre à jour</button>
        <a href="catalogue.php">Annuler</a>
    </form>
</body>
</html>