<?php if ($erreurAcces !== ''): ?>
	<div class="alert erreur">🚫 <?= htmlspecialchars($erreurAcces) ?></div>
<?php endif; ?>

<div class="topbar">
	<h1>Dashboard</h1>
</div>

<?php if (Auth::isAdmin()): ?>
	<div class="stats-grid">
		<div class="stat-card">
			<div class="label">Chiffre d'affaires</div>
			<div class="valeur accent"><?= number_format($statsVentes['chiffre_affaires'], 2) ?> MAD</div>
		</div>
		<div class="stat-card">
			<div class="label">Total ventes</div>
			<div class="valeur"><?= $statsVentes['total_ventes'] ?></div>
		</div>
		<div class="stat-card">
			<div class="label">Panier moyen</div>
			<div class="valeur"><?= number_format($statsVentes['panier_moyen'], 2) ?> MAD</div>
		</div>
		<div class="stat-card">
			<div class="label">Total produits</div>
			<div class="valeur"><?= $statsProduits['total_produits'] ?></div>
		</div>
		<div class="stat-card">
			<div class="label">Valeur du stock</div>
			<div class="valeur"><?= number_format($statsProduits['valeur_stock'], 2) ?> MAD</div>
		</div>
		<div class="stat-card">
			<div class="label">Alertes stock</div>
			<div class="valeur accent"><?= $statsProduits['alertes'] ?></div>
		</div>
	</div>
<?php else: ?>
	<div class="stats-grid">
		<div class="stat-card">
			<div class="label">Total produits</div>
			<div class="valeur"><?= $statsProduits['total_produits'] ?></div>
		</div>
		<div class="stat-card">
			<div class="label">Alertes stock</div>
			<div class="valeur accent"><?= $statsProduits['alertes'] ?></div>
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($lowStock)): ?>
	<div style="margin-bottom: 1rem;">
		<h2 style="font-size: 1.1rem; color: #1a1a2e; margin-bottom: 0.75rem; padding-left: 0.5rem; border-left: 4px solid #e94560;">
			Produits en alerte de stock
		</h2>
		<div class="table-wrapper">
			<table>
				<thead>
					<tr>
						<th>Produit</th>
						<th>Catégorie</th>
						<th>Fournisseur</th>
						<th>Stock actuel</th>
						<th>Seuil alerte</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lowStock as $p): ?>
						<tr>
							<td><?= htmlspecialchars($p->getNom()) ?></td>
							<td><span class="badge badge-cat"><?= htmlspecialchars($p->nomCategorie ?? '—') ?></span></td>
							<td><?= htmlspecialchars($p->nomFournisseur ?? '—') ?></td>
							<td><span class="badge badge-alerte"><?= $p->getQuantiteStock() ?></span></td>
							<td><?= $p->getSeuilAlerte() ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php else: ?>
	<div class="alert succes">✅ Tous les produits ont un stock suffisant.</div>
<?php endif; ?>
