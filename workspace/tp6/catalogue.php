<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
	header('Location: login.php');
	exit;
}

require_once 'connexion.php';
require_once 'film.php';
require_once 'auth.php';

$pdo = getConnexion();

$film = new Film('', '', 0, '', 0.0);

// -- Cookie de préférence d'affichage (Étape 6) -------------------------
$parPageOptions = [5, 10, 0]; // 0 = tous

if (isset($_GET['par_page'])) {
	$parPage = (int)$_GET['par_page'];
	setcookie('film_par_page', $parPage, time() + 30 * 24 * 3600, '/');
} elseif (isset($_COOKIE['film_par_page'])) {
	$parPage = (int)$_COOKIE['film_par_page'];
} else {
	$parPage = 0;
}

// -- Filtre par genre ---------------------------------------------------
$genreFiltre = trim($_GET['genre'] ?? '');

if ($genreFiltre !== '') {
	$films = Film::getByGenre($pdo, $genreFiltre);
} else {
	$films = $film->getAll($pdo, $parPage);
}

// -- Statistiques -------------------------------------------------------
$stats = $film->getStats($pdo);

$genres = ['Action', 'Animation', 'Aventure', 'Bollywood', 'Comédie', 'Documentaire',
           'Drame', 'Fantastique', 'Horreur', 'Romance', 'Science-fiction', 'Thriller'];

// -- Message d'erreur d'accès (Devoir) ----------------------------------
$erreurAcces = '';
if (isset($_SESSION['erreur_acces'])) {
	$erreurAcces = $_SESSION['erreur_acces'];
	unset($_SESSION['erreur_acces']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Catalogue – CinemaBD</title>
	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'Segoe UI', sans-serif;
			background: #f0f2f5;
			padding: 2rem;
		}

		.topbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 1.5rem;
			flex-wrap: wrap;
			gap: 0.75rem;
		}

		h1 {
			font-size: 1.6rem;
			color: #1a1a2e;
			border-left: 4px solid #e94560;
			padding-left: 0.75rem;
		}

		.user-info {
			display: flex;
			align-items: center;
			gap: 1rem;
			font-size: 0.9rem;
			color: #555;
		}

		.user-info strong {
			color: #1a1a2e;
		}

		.badge-role {
			padding: 0.2rem 0.6rem;
			border-radius: 20px;
			font-size: 0.78rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.04em;
		}

		.badge-role.admin {
			background: #fff3cd;
			color: #856404;
		}

		.badge-role.visiteur {
			background: #d1ecf1;
			color: #0c5460;
		}

		.btn-logout {
			padding: 0.4rem 1rem;
			background: #1a1a2e;
			color: #fff;
			border-radius: 8px;
			text-decoration: none;
			font-size: 0.85rem;
			font-weight: 600;
			transition: background 0.2s;
		}

		.btn-logout:hover {
			background: #2a2a4e;
		}

		.derniere-connexion {
			font-size: 0.8rem;
			color: #888;
			font-style: italic;
		}

		.alert-acces {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
			padding: 0.75rem 1rem;
			border-radius: 8px;
			margin-bottom: 1.25rem;
			font-size: 0.9rem;
		}

		.stats {
			display: flex;
			gap: 1rem;
			margin-bottom: 1.5rem;
			flex-wrap: wrap;
		}

		.stat-card {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.08);
			padding: 1rem 1.5rem;
			flex: 1;
			min-width: 160px;
		}

		.stat-card .label {
			font-size: 0.8rem;
			color: #888;
			margin-bottom: 0.25rem;
		}

		.stat-card .valeur {
			font-size: 1.3rem;
			font-weight: 700;
			color: #1a1a2e;
		}

		.barre-actions {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 1.25rem;
			flex-wrap: wrap;
			gap: 0.75rem;
		}

		.filtres {
			display: flex;
			gap: 0.5rem;
			align-items: center;
			flex-wrap: wrap;
		}

		.filtres select,
		.filtres input[type="number"] {
			padding: 0.5rem 0.75rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.9rem;
			background: #fff;
		}

		.filtres button {
			padding: 0.5rem 1rem;
			background: #1a1a2e;
			color: #fff;
			border: none;
			border-radius: 8px;
			font-size: 0.9rem;
			cursor: pointer;
		}

		.filtres button:hover {
			background: #2a2a4e;
		}

		.par-page-form {
			display: flex;
			align-items: center;
			gap: 0.5rem;
			font-size: 0.875rem;
			color: #555;
		}

		.par-page-form select {
			padding: 0.45rem 0.7rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.875rem;
			background: #fff;
		}

		.par-page-form button {
			padding: 0.45rem 0.9rem;
			background: #e94560;
			color: #fff;
			border: none;
			border-radius: 8px;
			font-size: 0.875rem;
			cursor: pointer;
		}

		.btn-ajouter {
			padding: 0.55rem 1.25rem;
			background: #e94560;
			color: #fff;
			border-radius: 8px;
			text-decoration: none;
			font-size: 0.9rem;
			font-weight: 600;
		}

		.btn-ajouter:hover {
			background: #c73652;
		}

		.table-wrapper {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			overflow: hidden;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		thead {
			background: #1a1a2e;
			color: #fff;
		}

		thead th {
			padding: 0.85rem 1rem;
			text-align: left;
			font-size: 0.85rem;
			font-weight: 600;
			letter-spacing: 0.04em;
		}

		tbody tr {
			border-bottom: 1px solid #f0f0f0;
			transition: background 0.15s;
		}

		tbody tr:last-child {
			border-bottom: none;
		}

		tbody tr:hover {
			background: #fafafa;
		}

		tbody td {
			padding: 0.8rem 1rem;
			font-size: 0.9rem;
			color: #333;
		}

		.note {
			font-weight: 700;
			color: #e94560;
		}

		.actions {
			display: flex;
			gap: 0.5rem;
		}

		.btn-modifier {
			padding: 0.3rem 0.75rem;
			background: #f0f2f5;
			color: #1a1a2e;
			border-radius: 6px;
			text-decoration: none;
			font-size: 0.82rem;
			font-weight: 600;
			border: 1px solid #ddd;
		}

		.btn-modifier:hover {
			background: #e0e2e8;
		}

		.btn-supprimer {
			padding: 0.3rem 0.75rem;
			background: #fff0f2;
			color: #e94560;
			border-radius: 6px;
			text-decoration: none;
			font-size: 0.82rem;
			font-weight: 600;
			border: 1px solid #f5c6cb;
		}

		.btn-supprimer:hover {
			background: #f8d7da;
		}

		.vide {
			text-align: center;
			padding: 2rem;
			color: #888;
			font-size: 0.95rem;
		}

		.badge-genre {
			background: #f0f2f5;
			color: #555;
			padding: 0.2rem 0.6rem;
			border-radius: 20px;
			font-size: 0.8rem;
		}
	</style>
</head>
<body>

<!-- -- Topbar --------------------------------------------------------- -->
<div class="topbar">
	<h1>🎬 Catalogue de films</h1>

	<div class="user-info">
		<?php if (isset($_COOKIE['derniere_connexion'])): ?>
			<span class="derniere-connexion">
				Dernière connexion : <?= htmlspecialchars($_COOKIE['derniere_connexion']) ?>
			</span>
		<?php endif; ?>

		<span>
			Bonjour, <strong><?= htmlspecialchars($_SESSION['utilisateur']) ?></strong>
			<span class="badge-role <?= htmlspecialchars($_SESSION['role']) ?>">
				<?= htmlspecialchars($_SESSION['role']) ?>
			</span>
		</span>

		<a href="logout.php" class="btn-logout">Déconnexion</a>
	</div>
</div>

<?php if ($erreurAcces !== ''): ?>
	<div class="alert-acces">
		🚫 <?= htmlspecialchars($erreurAcces) ?>
	</div>
<?php endif; ?>

<!-- -- Statistiques -------------------------------------------------- -->
<div class="stats">
	<div class="stat-card">
		<div class="label">Total de films</div>
		<div class="valeur"><?= $stats['total'] ?></div>
	</div>
	<div class="stat-card">
		<div class="label">Note moyenne</div>
		<div class="valeur"><?= $stats['note_moyenne'] ?> / 10</div>
	</div>
	<div class="stat-card">
		<div class="label">Meilleur film</div>
		<div class="valeur"><?= htmlspecialchars($stats['meilleur_film'] ?? '—') ?></div>
	</div>
</div>

<!-- -- Barre d'actions ----------------------------------------------- -->
<div class="barre-actions">
	<div class="filtres">
		<!-- Filtre par genre -->
		<form method="GET" action="catalogue.php" style="display:flex; gap:0.5rem; align-items:center;">
			<select name="genre">
				<option value="">— Tous les genres —</option>
				<?php foreach ($genres as $g): ?>
					<option value="<?= $g ?>" <?= ($genreFiltre === $g) ? 'selected' : '' ?>><?= $g ?></option>
				<?php endforeach; ?>
			</select>
			<?php if ($parPage !== 0): ?>
				<input type="hidden" name="par_page" value="<?= $parPage ?>">
			<?php endif; ?>
			<button type="submit">Filtrer</button>
			<?php if ($genreFiltre !== ''): ?>
				<a href="catalogue.php" style="font-size:0.85rem; color:#e94560; text-decoration:none;">✕ Réinitialiser</a>
			<?php endif; ?>
		</form>

		<!-- Films par page (cookie) -->
		<form class="par-page-form" method="GET" action="catalogue.php">
			<label for="par_page">Films / page :</label>
			<select id="par_page" name="par_page">
				<option value="5"  <?= ($parPage === 5)  ? 'selected' : '' ?>>5</option>
				<option value="10" <?= ($parPage === 10) ? 'selected' : '' ?>>10</option>
				<option value="0"  <?= ($parPage === 0)  ? 'selected' : '' ?>>Tous</option>
			</select>
			<?php if ($genreFiltre !== ''): ?>
				<input type="hidden" name="genre" value="<?= htmlspecialchars($genreFiltre) ?>">
			<?php endif; ?>
			<button type="submit">OK</button>
		</form>
	</div>

	<?php if (Auth::isAdmin()): ?>
		<a href="ajout.php" class="btn-ajouter">+ Ajouter un film</a>
	<?php endif; ?>
</div>

<!-- -- Tableau ------------------------------------------------------- -->
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Titre</th>
				<th>Réalisateur</th>
				<th>Année</th>
				<th>Genre</th>
				<th>Note</th>
				<?php if (Auth::isAdmin()): ?>
					<th>Actions</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($films)): ?>
				<tr>
					<td colspan="<?= Auth::isAdmin() ? 6 : 5 ?>" class="vide">Aucun film trouvé.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($films as $f): ?>
					<tr>
						<td><?= htmlspecialchars($f->getTitre()) ?></td>
						<td><?= htmlspecialchars($f->getRealisateur()) ?></td>
						<td><?= $f->getAnnee() ?></td>
						<td><span class="badge-genre"><?= htmlspecialchars($f->getGenre()) ?></span></td>
						<td class="note"><?= number_format($f->getNote(), 1) ?></td>
						<?php if (Auth::isAdmin()): ?>
							<td class="actions">
								<a href="modifierfilm.php?id=<?= $f->getId() ?>" class="btn-modifier">Modifier</a>
								<a href="supprimerfilm.php?id=<?= $f->getId() ?>" class="btn-supprimer"
								   onclick="return confirm('Supprimer « <?= htmlspecialchars($f->getTitre(), ENT_QUOTES) ?> » ?')">
									Supprimer
								</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

</body>
</html>
