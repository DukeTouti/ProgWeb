<?php
require_once 'connexion.php';
require_once 'Film.php';

$pdo = getConnexion();

$films = Film::getAll($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue de films</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Catalogue de films</h2>
    <a href="ajout.php">Ajouter un film</a>
    <table>
        <tr>
            <th>Titre</th>
            <th>Réalisateur</th>
            <th>Année</th>
            <th>Genre</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($films as $film): ?>
        <tr>
            <td><?= htmlspecialchars($film->getTitre()) ?></td>
            <td><?= htmlspecialchars($film->getRealisateur()) ?></td>
            <td><?= $film->getAnnee() ?></td>
            <td><?= htmlspecialchars($film->getGenre()) ?></td>
            <td><?= $film->getNote() ?></td>
            <td>
                <a href="modifierFilm.php?id=<?= $film->getId() ?>">Modifier</a>
                <a href="supprimerFilm.php?id=<?= $film->getId() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
