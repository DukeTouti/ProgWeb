<?php
session_start();

if (isset($_SESSION['utilisateur'])) {
	header('Location: catalogue.php');
	exit;
}

require_once 'connexion.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login       = trim($_POST['login']       ?? '');
	$mot_de_passe = trim($_POST['mot_de_passe'] ?? '');

	$pdo  = getConnexion();
	$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
	$stmt->bindValue(1, $login, PDO::PARAM_STR);
	$stmt->execute();

	$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
		$_SESSION['utilisateur'] = $utilisateur['login'];
		$_SESSION['role']        = $utilisateur['role'];

		// Cookie de dernière connexion (Devoir – Étape 6)
		setcookie(
			'derniere_connexion',
			date('d/m/Y H:i'),
			time() + 30 * 24 * 3600,
			'/'
		);

		header('Location: catalogue.php');
		exit;
	} else {
		$erreur = "Identifiants incorrects. Veuillez réessayer.";
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion – CinemaBD</title>
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
		}

		.logo {
			text-align: center;
			margin-bottom: 1.75rem;
		}

		.logo h1 {
			font-size: 1.6rem;
			color: #1a1a2e;
			border-left: 4px solid #e94560;
			padding-left: 0.75rem;
			text-align: left;
		}

		.logo p {
			color: #888;
			font-size: 0.875rem;
			margin-top: 0.35rem;
		}

		.message.erreur {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
			padding: 0.75rem 1rem;
			border-radius: 8px;
			margin-bottom: 1.25rem;
			font-size: 0.9rem;
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

		input {
			width: 100%;
			padding: 0.6rem 0.85rem;
			border: 1px solid #ccc;
			border-radius: 8px;
			font-size: 0.95rem;
			transition: border-color 0.2s;
			background: #fafafa;
		}

		input:focus {
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
	</style>
</head>
<body>
<div class="card">
	<div class="logo">
		<h1>🎬 CinemaBD</h1>
		<p>Connectez-vous pour accéder au catalogue</p>
	</div>

	<?php if ($erreur !== ''): ?>
		<div class="message erreur">
			<?= htmlspecialchars($erreur) ?>
		</div>
	<?php endif; ?>

	<form method="POST" action="login.php">
		<div class="form-group">
			<label for="login">Identifiant</label>
			<input
				type="text"
				id="login"
				name="login"
				placeholder="Ex : admin"
				value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
				required
				autofocus
			>
		</div>

		<div class="form-group">
			<label for="mot_de_passe">Mot de passe</label>
			<input
				type="password"
				id="mot_de_passe"
				name="mot_de_passe"
				placeholder="••••••••"
				required
			>
		</div>

		<button type="submit">Se connecter</button>
	</form>
</div>
</body>
</html>
