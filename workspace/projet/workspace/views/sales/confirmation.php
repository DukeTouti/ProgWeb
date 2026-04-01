<div class="topbar">
	<h1>Vente confirmée</h1>
</div>

<div class="card" style="max-width: 560px;">
	<div class="alert succes">✅ Vente enregistrée avec succès.</div>

	<table style="width: 100%; border-collapse: collapse; margin-bottom: 1.25rem;">
		<thead>
			<tr style="background: #f0f2f5;">
				<th style="padding: 0.6rem 0.75rem; text-align: left; font-size: 0.85rem; color: #555;">Produit</th>
				<th style="padding: 0.6rem 0.75rem; text-align: left; font-size: 0.85rem; color: #555;">Quantité</th>
				<th style="padding: 0.6rem 0.75rem; text-align: left; font-size: 0.85rem; color: #555;">Prix unitaire</th>
				<th style="padding: 0.6rem 0.75rem; text-align: left; font-size: 0.85rem; color: #555;">Sous-total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lignes as $ligne): ?>
				<tr style="border-bottom: 1px solid #f0f0f0;">
					<td style="padding: 0.65rem 0.75rem; font-size: 0.9rem;"><?= htmlspecialchars($ligne['product']->getNom()) ?></td>
					<td style="padding: 0.65rem 0.75rem; font-size: 0.9rem;"><?= $ligne['quantite'] ?></td>
					<td style="padding: 0.65rem 0.75rem; font-size: 0.9rem;"><?= number_format($ligne['product']->getPrixVente(), 2) ?> MAD</td>
					<td style="padding: 0.65rem 0.75rem; font-size: 0.9rem;"><?= number_format($ligne['product']->getPrixVente() * $ligne['quantite'], 2) ?> MAD</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 2px solid #1a1a2e; margin-bottom: 1.5rem;">
		<span style="font-weight: 700; font-size: 1rem; color: #1a1a2e;">Total TTC</span>
		<span style="font-size: 1.4rem; font-weight: 700; color: #e94560;"><?= number_format($totalTtc, 2) ?> MAD</span>
	</div>

	<div style="display: flex; gap: 0.75rem;">
		<a href="index.php?page=caisse" class="btn btn-primary">Nouvelle vente</a>
		<a href="index.php?page=history" class="btn btn-secondary">Voir l'historique</a>
	</div>
</div>
