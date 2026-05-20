<?php
// supprimerFilm.php - Suppression d'un film (admin seulement)
session_start();
require_once 'Auth.php';
Auth::requireLogin();
Auth::requireRole('admin');

require_once 'connexion.php';
require_once 'Film.php';

$id  = (int) ($_GET['id'] ?? 0);
$ok  = (new Film('', '', 0, '', 0.0))->delete($pdo, $id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px;
               margin: 60px auto; padding: 0 20px; }
        .ok  { color: green; } .ko { color: red; }
        a    { color: #0054a6; }
    </style>
</head>
<body>
    <?php if ($ok): ?>
        <p class="ok">✅ Film (id=<?= $id ?>) supprimé avec succès.</p>
    <?php else: ?>
        <p class="ko">❌ Erreur : film introuvable ou suppression échouée.</p>
    <?php endif; ?>
    <a href="catalogue.php">← Retour au catalogue</a>
</body>
</html>
