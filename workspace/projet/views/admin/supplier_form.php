<div class="topbar">
	<h1><?= $mode === 'add' ? 'Ajouter un fournisseur' : 'Modifier un fournisseur' ?></h1>
	<a href="index.php?page=suppliers" class="btn btn-secondary">← Retour aux fournisseurs</a>
</div>

<div class="card" style="max-width: 500px;">
	<?php if ($message !== ''): ?>
		<div class="alert <?= $erreur ? 'erreur' : 'succes' ?>"><?= htmlspecialchars($message) ?></div>
	<?php endif; ?>

	<form method="POST" action="index.php?page=<?= $mode === 'add' ? 'supplier-add' : 'supplier-edit&id=' . $supplier->getId() ?>">
		<?php if ($mode === 'edit'): ?>
			<input type="hidden" name="id" value="<?= $supplier->getId() ?>">
		<?php endif; ?>

		<div class="form-group">
			<label for="nom">Nom</label>
			<input
				type="text"
				id="nom"
				name="nom"
				placeholder="Ex : TechPro SARL"
				value="<?= htmlspecialchars($supplier ? $supplier->getNom() : ($_POST['nom'] ?? '')) ?>"
				required
			>
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input
				type="email"
				id="email"
				name="email"
				placeholder="Ex : contact@techpro.ma"
				value="<?= htmlspecialchars($supplier ? $supplier->getEmail() : ($_POST['email'] ?? '')) ?>"
			>
		</div>

		<div class="form-group">
			<label for="telephone">Téléphone</label>
			<input
				type="text"
				id="telephone"
				name="telephone"
				placeholder="Ex : 0661234567"
				value="<?= htmlspecialchars($supplier ? $supplier->getTelephone() : ($_POST['telephone'] ?? '')) ?>"
			>
		</div>

		<div class="form-group">
			<label for="id_user">Compte utilisateur lié (optionnel)</label>
			<select id="id_user" name="id_user">
				<option value="0">— Aucun —</option>
				<?php foreach ($users as $u): ?>
					<option value="<?= $u->getId() ?>" <?= ($supplier ? $supplier->getIdUser() : ($_POST['id_user'] ?? 0)) == $u->getId() ? 'selected' : '' ?>>
						<?= htmlspecialchars($u->getNom() . ' ' . $u->getPrenom() . ' (' . $u->getLogin() . ')') ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;">
			<?= $mode === 'add' ? 'Ajouter le fournisseur' : 'Enregistrer les modifications' ?>
		</button>
	</form>
</div>
