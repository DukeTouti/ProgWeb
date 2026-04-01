<?php if ($erreurAcces !== ''): ?>
	<div class="alert erreur">🚫 <?= htmlspecialchars($erreurAcces) ?></div>
<?php endif; ?>

<div class="topbar">
	<h1>Produits</h1>
	<?php if (Auth::isAdmin()): ?>
		<a href="index.php?page=product-add" class="btn btn-primary">+ Ajouter un produit</a>
	<?php endif; ?>
</div>

<div class="stats-grid">
	<div class="stat-card">
		<div class="label">Total produits</div>
		<div class="valeur"><?= $stats['total_produits'] ?></div>
	</div>
	<div class="stat-card">
		<div class="label">Total stock</div>
		<div class="valeur"><?= $stats['total_stock'] ?></div>
	</div>
	<div class="stat-card">
		<div class="label">Valeur du stock</div>
		<div class="valeur"><?= number_format($stats['valeur_stock'], 2) ?> MAD</div>
	</div>
	<div class="stat-card">
		<div class="label">Alertes stock</div>
		<div class="valeur accent"><?= $stats['alertes'] ?></div>
	</div>
</div>

<form method="GET" action="index.php" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
	<input type="hidden" name="page" value="products">

	<div class="form-group" style="margin: 0; flex: 1; min-width: 150px;">
		<label>Nom</label>
		<input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" placeholder="Rechercher...">
	</div>

	<div class="form-group" style="margin: 0; flex: 1; min-width: 150px;">
		<label>Catégorie</label>
		<select name="id_categorie">
			<option value="0">— Toutes —</option>
			<?php foreach ($categories as $c): ?>
				<option value="<?= $c->getId() ?>" <?= $idCategorie === $c->getId() ? 'selected' : '' ?>><?= htmlspecialchars($c->getNom()) ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group" style="margin: 0; flex: 1; min-width: 150px;">
		<label>Fournisseur</label>
		<select name="id_fournisseur">
			<option value="0">— Tous —</option>
			<?php foreach ($suppliers as $s): ?>
				<option value="<?= $s->getId() ?>" <?= $idFournisseur === $s->getId() ? 'selected' : '' ?>><?= htmlspecialchars($s->getNom()) ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div style="display: flex; gap: 0.5rem;">
		<button type="submit" class="btn btn-primary">Filtrer</button>
		<a href="index.php?page=products" class="btn btn-secondary">Réinitialiser</a>
	</div>
</form>

<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Catégorie</th>
				<th>Fournisseur</th>
				<th>Prix achat</th>
				<th>Prix vente</th>
				<th>Stock</th>
				<th>Seuil</th>
				<?php if (Auth::isAdmin()): ?>
					<th>Actions</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($products)): ?>
				<tr>
					<td colspan="<?= Auth::isAdmin() ? 8 : 7 ?>" class="vide">Aucun produit trouvé.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($products as $p): ?>
					<tr>
						<td><?= htmlspecialchars($p->getNom()) ?></td>
						<td><span class="badge badge-cat"><?= htmlspecialchars($p->nomCategorie ?? '—') ?></span></td>
						<td><?= htmlspecialchars($p->nomFournisseur ?? '—') ?></td>
						<td><?= number_format($p->getPrixAchat(), 2) ?> MAD</td>
						<td><?= number_format($p->getPrixVente(), 2) ?> MAD</td>
						<td>
							<span class="badge <?= $p->isLowStock() ? 'badge-alerte' : 'badge-ok' ?>">
								<?= $p->getQuantiteStock() ?>
							</span>
						</td>
						<td><?= $p->getSeuilAlerte() ?></td>
						<?php if (Auth::isAdmin()): ?>
							<td class="actions">
								<a href="index.php?page=product-edit&id=<?= $p->getId() ?>" class="btn btn-secondary">Modifier</a>
								<a href="index.php?page=product-delete&id=<?= $p->getId() ?>" class="btn btn-danger" onclick="return confirm('Supprimer « <?= htmlspecialchars($p->getNom(), ENT_QUOTES) ?> » ?')">Supprimer</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
