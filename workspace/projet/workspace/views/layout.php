<?php
$user = Auth::getCurrentUser();
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GestionMagasin</title>
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
			min-height: 100vh;
		}

		/* Sidebar */
		.sidebar {
			width: 220px;
			background: #1a1a2e;
			display: flex;
			flex-direction: column;
			padding: 1.5rem 0;
			position: fixed;
			top: 0;
			left: 0;
			height: 100vh;
		}

		.sidebar .logo {
			font-size: 1.2rem;
			font-weight: 700;
			color: #fff;
			padding: 0 1.25rem 1.5rem;
			border-bottom: 1px solid rgba(255,255,255,0.1);
			margin-bottom: 1rem;
		}

		.sidebar .logo span {
			color: #e94560;
		}

		.sidebar nav a {
			display: block;
			padding: 0.65rem 1.25rem;
			color: rgba(255,255,255,0.7);
			text-decoration: none;
			font-size: 0.9rem;
			transition: all 0.2s;
			border-left: 3px solid transparent;
		}

		.sidebar nav a:hover,
		.sidebar nav a.active {
			color: #fff;
			background: rgba(255,255,255,0.07);
			border-left-color: #e94560;
		}

		.sidebar .nav-section {
			font-size: 0.7rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.08em;
			color: rgba(255,255,255,0.3);
			padding: 1rem 1.25rem 0.4rem;
		}

		.sidebar .user-block {
			margin-top: auto;
			padding: 1rem 1.25rem;
			border-top: 1px solid rgba(255,255,255,0.1);
			font-size: 0.82rem;
			color: rgba(255,255,255,0.5);
		}

		.sidebar .user-block strong {
			display: block;
			color: #fff;
			margin-bottom: 0.2rem;
		}

		.sidebar .user-block .badge-role {
			display: inline-block;
			padding: 0.15rem 0.5rem;
			border-radius: 20px;
			font-size: 0.72rem;
			font-weight: 700;
			text-transform: uppercase;
			margin-bottom: 0.6rem;
		}

		.badge-role.admin {
			background: #fff3cd;
			color: #856404;
		}

		.badge-role.vendeur {
			background: #d1ecf1;
			color: #0c5460;
		}

		.badge-role.fournisseur {
			background: #d4edda;
			color: #155724;
		}

		.sidebar .btn-logout {
			display: block;
			padding: 0.4rem 0.75rem;
			background: #e94560;
			color: #fff;
			border-radius: 6px;
			text-decoration: none;
			font-size: 0.82rem;
			font-weight: 600;
			text-align: center;
			transition: background 0.2s;
		}

		.sidebar .btn-logout:hover {
			background: #c73652;
		}

		/* Main */
		.main {
			margin-left: 220px;
			flex: 1;
			padding: 2rem;
		}

		.topbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 1.75rem;
		}

		.topbar h1 {
			font-size: 1.5rem;
			color: #1a1a2e;
			border-left: 4px solid #e94560;
			padding-left: 0.75rem;
		}

		.derniere-connexion {
			font-size: 0.8rem;
			color: #888;
			font-style: italic;
		}

		/* Cards */
		.card {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			padding: 2rem 2.5rem;
		}

		/* Alertes */
		.alert {
			padding: 0.75rem 1rem;
			border-radius: 8px;
			margin-bottom: 1.25rem;
			font-size: 0.9rem;
		}

		.alert.succes {
			background: #d4edda;
			color: #155724;
			border: 1px solid #c3e6cb;
		}

		.alert.erreur {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

		.alert.warning {
			background: #fff3cd;
			color: #856404;
			border: 1px solid #ffeeba;
		}

		/* Formulaires */
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

		input, select, textarea {
			width: 100%;
			padding: 0.6rem 0.85rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.95rem;
			transition: border-color 0.2s;
			background: #fafafa;
			font-family: inherit;
		}

		input:focus, select:focus, textarea:focus {
			outline: none;
			border-color: #e94560;
			background: #fff;
		}

		/* Boutons */
		.btn {
			display: inline-block;
			padding: 0.6rem 1.25rem;
			border-radius: 8px;
			font-size: 0.9rem;
			font-weight: 600;
			cursor: pointer;
			text-decoration: none;
			border: none;
			transition: background 0.2s;
		}

		.btn-primary {
			background: #e94560;
			color: #fff;
		}

		.btn-primary:hover {
			background: #c73652;
		}

		.btn-secondary {
			background: #f0f2f5;
			color: #1a1a2e;
			border: 1px solid #ddd;
		}

		.btn-secondary:hover {
			background: #e0e2e8;
		}

		.btn-danger {
			background: #fff0f2;
			color: #e94560;
			border: 1px solid #f5c6cb;
		}

		.btn-danger:hover {
			background: #f8d7da;
		}

		/* Tableaux */
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

		.vide {
			text-align: center;
			padding: 2rem;
			color: #888;
			font-size: 0.95rem;
		}

		/* Badges */
		.badge {
			display: inline-block;
			padding: 0.2rem 0.6rem;
			border-radius: 20px;
			font-size: 0.78rem;
			font-weight: 600;
		}

		.badge-alerte {
			background: #f8d7da;
			color: #721c24;
		}

		.badge-ok {
			background: #d4edda;
			color: #155724;
		}

		.badge-cat {
			background: #f0f2f5;
			color: #555;
		}

		/* Stats */
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 1rem;
			margin-bottom: 1.75rem;
		}

		.stat-card {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.08);
			padding: 1.25rem 1.5rem;
		}

		.stat-card .label {
			font-size: 0.8rem;
			color: #888;
			margin-bottom: 0.3rem;
		}

		.stat-card .valeur {
			font-size: 1.4rem;
			font-weight: 700;
			color: #1a1a2e;
		}

		.stat-card .valeur.accent {
			color: #e94560;
		}

		/* Actions tableau */
		.actions {
			display: flex;
			gap: 0.5rem;
		}
	</style>
</head>
<body>

<aside class="sidebar">
	<div class="logo">Gestion<span>Magasin</span></div>

	<nav>
		<div class="nav-section">Principal</div>
		<a href="index.php?page=dashboard" class="<?= $page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
		<a href="index.php?page=products" class="<?= $page === 'products' ? 'active' : '' ?>">Produits</a>

		<?php if (Auth::isAdmin() || Auth::isVendeur()): ?>
			<div class="nav-section">Ventes</div>
			<a href="index.php?page=caisse" class="<?= $page === 'caisse' ? 'active' : '' ?>">Caisse</a>
			<a href="index.php?page=history" class="<?= $page === 'history' ? 'active' : '' ?>">Historique</a>
		<?php endif; ?>

		<?php if (Auth::isAdmin()): ?>
			<div class="nav-section">Administration</div>
			<a href="index.php?page=users" class="<?= $page === 'users' ? 'active' : '' ?>">Utilisateurs</a>
			<a href="index.php?page=suppliers" class="<?= $page === 'suppliers' ? 'active' : '' ?>">Fournisseurs</a>
		<?php endif; ?>
	</nav>

	<div class="user-block">
		<strong><?= htmlspecialchars($user['nom']) ?></strong>
		<span class="badge-role <?= htmlspecialchars($user['role']) ?>"><?= htmlspecialchars($user['role']) ?></span>
		<?php if (isset($_COOKIE['derniere_connexion'])): ?>
			<div class="derniere-connexion" style="margin-bottom: 0.6rem;">
				Dernière connexion :<br><?= htmlspecialchars($_COOKIE['derniere_connexion']) ?>
			</div>
		<?php endif; ?>
		<a href="index.php?page=logout" class="btn-logout">Déconnexion</a>
	</div>
</aside>

<main class="main">
	<?php require_once __DIR__ . '/' . $vue . '.php'; ?>
</main>

</body>
</html>
