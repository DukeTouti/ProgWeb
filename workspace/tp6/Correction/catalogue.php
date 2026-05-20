<?php
// catalogue.php - Affichage du catalogue + garde de session + cookie preference
session_start();

// --- Etape 4 : Garde de session ---
if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

require_once 'connexion.php';
require_once 'Film.php';
require_once 'Auth.php';

// --- Etape 6 : Gestion du cookie "par_page" ---
if (isset($_GET['par_page'])) {
    $parPage = (int) $_GET['par_page'];
    setcookie('cinema_par_page', $parPage, time() + 30 * 24 * 3600, '/');
} elseif (isset($_COOKIE['cinema_par_page'])) {
    $parPage = (int) $_COOKIE['cinema_par_page'];
} else {
    $parPage = 5; // valeur par defaut
}

// Recuperer les films (avec LIMIT si besoin)
$film  = new Film('', '', 0, '', 0.0);
$films = $film->getAll($pdo, $parPage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue de films – CinemaBD</title>
    <style>
        body  { font-family: Arial, sans-serif; max-width: 960px;
                margin: 30px auto; padding: 0 20px; }
        h1    { color: #0054a6; }
        .topbar { display: flex; justify-content: space-between;
                  align-items: center; background: #f0f5ff;
                  padding: 10px 16px; border-radius: 6px; margin-bottom: 16px; }
        .topbar a { color: #c0392b; text-decoration: none; font-weight: bold; }
        .stats-box { background: #fffbe6; border-left: 4px solid #e6ac00;
                     padding: 10px 16px; border-radius: 4px; margin-bottom: 16px; }
        .erreur-acces { background: #fff0f0; border-left: 4px solid red;
                        padding: 8px 12px; margin-bottom: 12px; color: red; }
        table { width: 100%; border-collapse: collapse; }
        th    { background: #0054a6; color: white; padding: 10px; text-align: left; }
        td    { padding: 8px 10px; border-bottom: 1px solid #ddd; }
        tr:hover td { background: #f5f8ff; }
        .actions a { margin-right: 8px; text-decoration: none; }
        .btn-edit   { color: #0054a6; font-weight: bold; }
        .btn-delete { color: #c0392b; font-weight: bold; }
        .note { font-weight: bold; color: #27ae60; }
        select { padding: 4px 8px; border-radius: 4px; }
        .derniere-cnx { font-size: 0.85em; color: #666; margin-bottom: 8px; }
    </style>
</head>
<body>

<h1>🎬 Catalogue de films</h1>

<!-- Etape 5 : Barre utilisateur + deconnexion -->
<div class="topbar">
    <span>
        Bienvenue, <strong><?= htmlspecialchars($_SESSION['utilisateur']) ?></strong>
        <?= Auth::isAdmin() ? ' <em>(admin)</em>' : ' <em>(visiteur)</em>' ?>
    </span>
    <a href="logout.php">Se déconnecter</a>
</div>

<!-- Devoir : affichage cookie derniere connexion -->
<?php if (isset($_COOKIE['derniere_connexion'])): ?>
    <p class="derniere-cnx">
        Dernière connexion : <?= htmlspecialchars($_COOKIE['derniere_connexion']) ?>
    </p>
<?php endif; ?>

<!-- Message d'erreur d'acces (depuis Auth::requireRole) -->
<?php if (isset($_SESSION['erreur_acces'])): ?>
    <div class="erreur-acces"><?= htmlspecialchars($_SESSION['erreur_acces']) ?></div>
    <?php unset($_SESSION['erreur_acces']); ?>
<?php endif; ?>

<!-- Stats (Devoir TP5 - getStats) -->
<?php
$stats = $film->getStats($pdo);
if ($stats):
?>
<div class="stats-box">
    📊 <strong><?= $stats['total'] ?></strong> films &nbsp;|&nbsp;
    Note moyenne : <strong><?= $stats['note_moyenne'] ?></strong> &nbsp;|&nbsp;
    Meilleur film : <strong><?= htmlspecialchars($stats['meilleur_film']) ?></strong>
</div>
<?php endif; ?>

<!-- Etape 6 : Selecteur par_page (cookie) -->
<form method="get" style="margin-bottom:12px;">
    <label>Films par page :
        <select name="par_page" onchange="this.form.submit()">
            <option value="5"  <?= $parPage === 5  ? 'selected' : '' ?>>5</option>
            <option value="10" <?= $parPage === 10 ? 'selected' : '' ?>>10</option>
            <option value="0"  <?= $parPage === 0  ? 'selected' : '' ?>>Tous</option>
        </select>
    </label>
</form>

<!-- Bouton ajout (admin seulement) -->
<?php if (Auth::isAdmin()): ?>
    <p><a href="ajout.php" style="background:#0054a6;color:white;
        padding:8px 16px;border-radius:4px;text-decoration:none;">
        + Ajouter un film
    </a></p>
<?php endif; ?>

<!-- Tableau des films -->
<table>
    <thead>
        <tr>
            <th>#</th><th>Titre</th><th>Réalisateur</th>
            <th>Année</th><th>Genre</th><th>Note</th>
            <?php if (Auth::isAdmin()): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($films)): ?>
        <tr><td colspan="7" style="text-align:center;color:#999;">
            Aucun film dans le catalogue.
        </td></tr>
    <?php else: ?>
        <?php foreach ($films as $f): ?>
        <tr>
            <td><?= $f->getId() ?></td>
            <td><?= htmlspecialchars($f->getTitre()) ?></td>
            <td><?= htmlspecialchars($f->getRealisateur()) ?></td>
            <td><?= $f->getAnnee() ?></td>
            <td><?= htmlspecialchars($f->getGenre()) ?></td>
            <td class="note"><?= number_format($f->getNote(), 1) ?>/10</td>

            <!-- Etape 5 / Devoir : actions conditionnelles selon role -->
            <?php if (Auth::isAdmin()): ?>
            <td class="actions">
                <a class="btn-edit"
                   href="modifierFilm.php?id=<?= $f->getId() ?>">Modifier</a>
                <a class="btn-delete"
                   href="supprimerFilm.php?id=<?= $f->getId() ?>"
                   onclick="return confirm('Supprimer ce film ?')">Supprimer</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
