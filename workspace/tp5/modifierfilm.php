<?php
require_once 'connexion.php';
require_once 'film.php';

$id      = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$message = '';
$erreur  = false;
$film    = null;

$pdo = getConnexion();

// -- Traitement du formulaire POST ------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$titre       = trim($_POST['titre']       ?? '');
	$realisateur = trim($_POST['realisateur'] ?? '');
	$annee       = (int)($_POST['annee']      ?? 0);
	$genre       = trim($_POST['genre']       ?? '');
	$note        = (float)($_POST['note']     ?? 0);

	$film = new Film($titre, $realisateur, $annee, $genre, $note, $id);

	if ($film->update($pdo)) {
		header('Location: catalogue.php');
		exit;
	} else {
		$message = "Erreur lors de la mise à jour.";
		$erreur  = true;
	}
}

// -- Chargement du film en GET (ou apres echec POST) ------------------
if ($film === null) {
	$filmTemp = new Film('', '', 0, '', 0.0);
	$film     = $filmTemp->findById($pdo, $id);
}

$genres = ['Action', 'Animation', 'Aventure', 'Bollywood', 'Comédie', 'Documentaire',
           'Drame', 'Fantastique', 'Horreur', 'Romance', 'Science-fiction', 'Thriller'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Modifier un film – CinemaBD</title>
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

		.erreur-introuvable {
			text-align: center;
			color: #721c24;
			font-size: 0.95rem;
			margin-bottom: 1rem;
		}
	</style>
</head>
<body>
<div class="card">
	<h1>✏️ Modifier un film</h1>

	<?php if ($film === null): ?>
		<p class="erreur-introuvable">Film introuvable (id = <?= $id ?>).</p>
		<div class="lien-catalogue">
			<a href="catalogue.php">← Retour au catalogue</a>
		</div>
	<?php else: ?>

		<?php if ($message !== ''): ?>
			<div class="message erreur">
				<?= htmlspecialchars($message) ?>
			</div>
		<?php endif; ?>

		<form method="POST" action="modifierfilm.php?id=<?= $film->getId() ?>">
			<input type="hidden" name="id" value="<?= $film->getId() ?>">

			<div class="form-group">
				<label for="titre">Titre</label>
				<input
					type="text"
					id="titre"
					name="titre"
					value="<?= htmlspecialchars($film->getTitre()) ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="realisateur">Réalisateur</label>
				<input
					type="text"
					id="realisateur"
					name="realisateur"
					value="<?= htmlspecialchars($film->getRealisateur()) ?>"
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
					value="<?= $film->getAnnee() ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="genre">Genre</label>
				<select id="genre" name="genre" required>
					<option value="" disabled>-- Choisir un genre --</option>
					<?php foreach ($genres as $g): ?>
						<option value="<?= $g ?>" <?= ($film->getGenre() === $g) ? 'selected' : '' ?>><?= $g ?></option>
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
					value="<?= $film->getNote() ?>"
					required
				>
			</div>

			<button type="submit">Enregistrer les modifications</button>
		</form>

		<div class="lien-catalogue">
			<a href="catalogue.php">← Retour au catalogue</a>
		</div>

	<?php endif; ?>
</div>
</body>
</html>
