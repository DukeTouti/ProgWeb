<?php
require_once 'connexion.php';
require_once 'film.php';

$message = '';
$erreur  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$titre       = trim($_POST['titre']       ?? '');
	$realisateur = trim($_POST['realisateur'] ?? '');
	$annee       = (int)($_POST['annee']      ?? 0);
	$genre       = trim($_POST['genre']       ?? '');
	$note        = (float)($_POST['note']     ?? 0);
	
	$pdo = getConnexion();

	$film = new Film($titre, $realisateur, $annee, $genre, $note);

	if ($film->save($pdo)) {
		$message = "Film \"$titre\" ajouté avec succès.";
	} else {
		$message = "Erreur lors de l'ajout du film.";
		$erreur  = true;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajouter un film – CinemaBD</title>
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
			max-width: 480px;
		}

		h1 {
			font-size: 1.5rem;
			color: #1a1a2e;
			margin-bottom: 1.5rem;
			border-left: 4px solid #e94560;
			padding-left: 0.75rem;
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

		.form-group {
			margin-bottom: 1.1rem;
		}

		label {
			display: block;
			font-size: 0.875rem;
			font-weight: 600;
			color: #444;
			margin-bottom: 0.35rem;
		}

		input, select {
			width: 100%;
			padding: 0.6rem 0.85rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.95rem;
			transition: border-color 0.2s;
			background: #fafafa;
		}

		input:focus, select:focus {
			outline: none;
			border-color: #e94560;
			background: #fff;
		}

		button {
			width: 100%;
			padding: 0.75rem;
			background: #e94560;
			color: #fff;
			border: none;
			border-radius: 8px;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			margin-top: 0.5rem;
			transition: background 0.2s;
		}

		button:hover {
			background: #c73652;
		}

		.lien-catalogue {
			text-align: center;
			margin-top: 1rem;
			font-size: 0.875rem;
		}

		.lien-catalogue a {
			color: #e94560;
			text-decoration: none;
		}

		.lien-catalogue a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
<div class="card">
	<h1>🎬 Ajouter un film</h1>

	<?php if ($message !== ''): ?>
		<div class="message <?= $erreur ? 'erreur' : 'succes' ?>">
			<?= htmlspecialchars($message) ?>
		</div>
	<?php endif; ?>

	<form method="POST" action="ajout.php">

		<div class="form-group">
			<label for="titre">Titre</label>
			<input
				type="text"
				id="titre"
				name="titre"
				placeholder="Ex : Inception"
				value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
				required
			>
		</div>

		<div class="form-group">
			<label for="realisateur">Réalisateur</label>
			<input
				type="text"
				id="realisateur"
				name="realisateur"
				placeholder="Ex : Christopher Nolan"
				value="<?= htmlspecialchars($_POST['realisateur'] ?? '') ?>"
				required
			>
		</div>

		<div class="form-group">
			<label for="annee">Année</label>
			<input
				type="number"
				id="annee"
				name="annee"
				min="1888"
				max="<?= date('Y') ?>"
				placeholder="Ex : 2010"
				value="<?= htmlspecialchars($_POST['annee'] ?? '') ?>"
				required
			>
		</div>

		<div class="form-group">
			<label for="genre">Genre</label>
			<select id="genre" name="genre" required>
				<option value="" disabled <?= empty($_POST['genre']) ? 'selected' : '' ?>>-- Choisir un genre --</option>
				<?php
				$genres = ['Action', 'Animation', 'Aventure', 'Bollywood', 'Comédie', 'Documentaire',
				           'Drame', 'Fantastique', 'Horreur', 'Romance', 'Science-fiction',
				           'Thriller'];
				foreach ($genres as $g):
					$sel = (($_POST['genre'] ?? '') === $g) ? 'selected' : '';
				?>
					<option value="<?= $g ?>" <?= $sel ?>><?= $g ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="note">Note (0.0 – 10.0)</label>
			<input
				type="number"
				id="note"
				name="note"
				min="0"
				max="10"
				step="0.1"
				placeholder="Ex : 8.5"
				value="<?= htmlspecialchars($_POST['note'] ?? '') ?>"
				required
			>
		</div>

		<button type="submit">Ajouter le film</button>
	</form>

	<div class="lien-catalogue">
		<a href="catalogue.php">← Retour au catalogue</a>
	</div>
</div>
</body>
</html>
