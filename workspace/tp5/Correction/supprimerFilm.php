<?php
require_once 'Film.php';
require_once 'connexion.php';

$id = $_GET['id'] ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $pdo = getConnexion();
    $resultat = Film::delete($pdo, $id);
} else {
    $resultat = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un film</title>
</head>
<body>
    <h2>Supprimer un film</h2>
    <?php if ($resultat): ?>
        <p style='color: green;'>Le film a été supprimé avec succès.</p>
    <?php else: ?>
        <p style='color: red;'>Une erreur est survenue lors de la suppression du film.</p>
    <?php endif; ?>
    <a href="catalogue.php">Retour au catalogue</a>
</body>
</html>