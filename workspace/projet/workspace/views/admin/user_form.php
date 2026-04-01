<div class="topbar">
	<h1><?= $mode === 'add' ? 'Ajouter un utilisateur' : 'Modifier un utilisateur' ?></h1>
	<a href="index.php?page=users" class="btn btn-secondary">← Retour aux utilisateurs</a>
</div>

<div class="card" style="max-width: 500px;">
	<?php if ($message !== ''): ?>
		<div class="alert <?= $erreur ? 'erreur' : 'succes' ?>"><?= htmlspecialchars($message) ?></div>
	<?php endif; ?>

	<form method="POST" action="index.php?page=<?= $mode === 'add' ? 'user-add' : 'user-edit&id=' . $user->getId() ?>">
		<?php if ($mode === 'edit'): ?>
			<input type="hidden" name="id" value="<?= $user->getId() ?>">
		<?php endif; ?>

		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
			<div class="form-group">
				<label for="nom">Nom</label>
				<input
					type="text"
					id="nom"
					name="nom"
					placeholder="Ex : Dupont"
					value="<?= htmlspecialchars($user ? $user->getNom() : ($_POST['nom'] ?? '')) ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="prenom">Prénom</label>
				<input
					type="text"
					id="prenom"
					name="prenom"
					placeholder="Ex : Jean"
					value="<?= htmlspecialchars($user ? $user->getPrenom() : ($_POST['prenom'] ?? '')) ?>"
					required
				>
			</div>
		</div>

		<div class="form-group">
			<label for="login">Login</label>
			<input
				type="text"
				id="login"
				name="login"
				placeholder="Ex : jdupont"
				value="<?= htmlspecialchars($user ? $user->getLogin() : ($_POST['login'] ?? '')) ?>"
				required
			>
		</div>

		<?php if ($mode === 'add'): ?>
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input
					type="password"
					id="password"
					name="password"
					placeholder="••••••••"
					required
				>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="role">Rôle</label>
			<select id="role" name="role">
				<option value="vendeur" <?= ($user ? $user->getRole() : ($_POST['role'] ?? '')) === 'vendeur' ? 'selected' : '' ?>>Vendeur</option>
				<option value="admin" <?= ($user ? $user->getRole() : ($_POST['role'] ?? '')) === 'admin' ? 'selected' : '' ?>>Administrateur</option>
				<option value="fournisseur" <?= ($user ? $user->getRole() : ($_POST['role'] ?? '')) === 'fournisseur' ? 'selected' : '' ?>>Fournisseur</option>
			</select>
		</div>

		<button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;">
			<?= $mode === 'add' ? 'Créer l\'utilisateur' : 'Enregistrer les modifications' ?>
		</button>
	</form>
</div>
