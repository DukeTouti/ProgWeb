<div class="topbar">
	<h1>Historique des ventes</h1>
</div>

<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Vendeur</th>
				<th>Date</th>
				<th>Total TTC</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($sales)): ?>
				<tr>
					<td colspan="4" class="vide">Aucune vente enregistrée.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($sales as $s): ?>
					<tr>
						<td style="color: #888; font-size: 0.85rem;">#<?= $s->getId() ?></td>
						<td><?= htmlspecialchars($s->nomVendeur) ?></td>
						<td><?= htmlspecialchars($s->getDateVente()) ?></td>
						<td style="font-weight: 700; color: #e94560;"><?= number_format($s->getTotalTtc(), 2) ?> MAD</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
