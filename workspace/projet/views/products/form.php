<div class="topbar">
	<h1><?= $mode === 'add' ? 'Ajouter un produit' : 'Modifier un produit' ?></h1>
	<a href="index.php?page=products" class="btn btn-secondary">← Retour aux produits</a>
</div>

<div class="card" style="max-width: 600px;">
	<?php if ($message !== ''): ?>
		<div class="alert <?= $erreur ? 'erreur' : 'succes' ?>"><?= htmlspecialchars($message) ?></div>
	<?php endif; ?>

	<form method="POST" action="index.php?page=<?= $mode === 'add' ? 'product-add' : 'product-edit&id=' . $product->getId() ?>">
		<?php if ($mode === 'edit'): ?>
			<input type="hidden" name="id" value="<?= $product->getId() ?>">
		<?php endif; ?>

		<div class="form-group">
			<label for="nom">Nom</label>
			<input
				type="text"
				id="nom"
				name="nom"
				placeholder="Ex : Laptop Dell"
				value="<?= htmlspecialchars($product ? $product->getNom() : ($_POST['nom'] ?? '')) ?>"
				required
			>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea
				id="description"
				name="description"
				rows="3"
				placeholder="Ex : Core i5 8Go RAM"
			><?= htmlspecialchars($product ? $product->getDescription() : ($_POST['description'] ?? '')) ?></textarea>
		</div>

		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
			<div class="form-group">
				<label for="prix_achat">Prix achat (MAD)</label>
				<input
					type="number"
					id="prix_achat"
					name="prix_achat"
					min="0"
					step="0.01"
					placeholder="Ex : 4500.00"
					value="<?= htmlspecialchars($product ? $product->getPrixAchat() : ($_POST['prix_achat'] ?? '')) ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="prix_vente">Prix vente (MAD)</label>
				<input
					type="number"
					id="prix_vente"
					name="prix_vente"
					min="0"
					step="0.01"
					placeholder="Ex : 6200.00"
					value="<?= htmlspecialchars($product ? $product->getPrixVente() : ($_POST['prix_vente'] ?? '')) ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="quantite_stock">Quantité en stock</label>
				<input
					type="number"
					id="quantite_stock"
					name="quantite_stock"
					min="0"
					placeholder="Ex : 12"
					value="<?= htmlspecialchars($product ? $product->getQuantiteStock() : ($_POST['quantite_stock'] ?? '')) ?>"
					required
				>
			</div>

			<div class="form-group">
				<label for="seuil_alerte">Seuil d'alerte</label>
				<input
					type="number"
					id="seuil_alerte"
					name="seuil_alerte"
					min="0"
					placeholder="Ex : 5"
					value="<?= htmlspecialchars($product ? $product->getSeuilAlerte() : ($_POST['seuil_alerte'] ?? 5)) ?>"
					required
				>
			</div>
		</div>

		<div class="form-group">
			<label for="id_categorie">Catégorie</label>
			<select id="id_categorie" name="id_categorie">
				<option value="0">— Aucune —</option>
				<?php foreach ($categories as $c): ?>
					<option value="<?= $c->getId() ?>" <?= ($product ? $product->getIdCategorie() : ($_POST['id_categorie'] ?? 0)) == $c->getId() ? 'selected' : '' ?>>
						<?= htmlspecialchars($c->getNom()) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="id_fournisseur">Fournisseur</label>
			<select id="id_fournisseur" name="id_fournisseur">
				<option value="0">— Aucun —</option>
				<?php foreach ($suppliers as $s): ?>
					<option value="<?= $s->getId() ?>" <?= ($product ? $product->getIdFournisseur() : ($_POST['id_fournisseur'] ?? 0)) == $s->getId() ? 'selected' : '' ?>>
						<?= htmlspecialchars($s->getNom()) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;">
			<?= $mode === 'add' ? 'Ajouter le produit' : 'Enregistrer les modifications' ?>
		</button>
	</form>
</div>
