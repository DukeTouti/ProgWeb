<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
	header('Location: login.php');
	exit;
}

require_once 'auth.php';
Auth::requireLogin();
Auth::requireRole('admin');

require_once 'connexion.php';
require_once 'film.php';

$id      = (int)($_GET['id'] ?? 0);
$message = '';
$erreur  = false;

if ($id <= 0) {
	$message = "Identifiant invalide.";
	$erreur  = true;
} else {
	$pdo  = getConnexion();
	$film = new Film('', '', 0, '', 0.0);

	if ($film->delete($pdo, $id)) {
		$message = "Film supprimé avec succès.";
	} else {
		$message = "Erreur lors de la suppression.";
		$erreur  = true;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Suppression – CinemaBD</title>
	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'Segoe UI', sans-serif;
			background: #f0f2f5;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			padding: 2rem;
		}

		.card {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.1);
			padding: 2rem 2.5rem;
			width: 100%;
			max-width: 420px;
			text-align: center;
		}

		h1 {
			font-size: 1.4rem;
			color: #1a1a2e;
			margin-bottom: 1.25rem;
		}

		.message {
			padding: 0.75rem 1rem;
			border-radius: 8px;
			margin-bottom: 1.25rem;
			font-size: 0.95rem;
		}

		.message.succes {
			background: #d4edda;
			color: #155724;
			border: 1px solid #c3e6cb;
		}

		.message.erreur {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

		a {
			display: inline-block;
			margin-top: 0.5rem;
			padding: 0.65rem 1.5rem;
			background: #e94560;
			color: #fff;
			border-radius: 8px;
			text-decoration: none;
			font-weight: 600;
			font-size: 0.95rem;
		}

		a:hover {
			background: #c73652;
		}
	</style>
</head>
<body>
<div class="card">
	<h1>🗑️ Suppression de film</h1>

	<div class="message <?= $erreur ? 'erreur' : 'succes' ?>">
		<?= htmlspecialchars($message) ?>
	</div>

	<a href="catalogue.php">← Retour au catalogue</a>
</div>
</body>
</html>
