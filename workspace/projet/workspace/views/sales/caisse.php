<?php if ($message !== ''): ?>
	<div class="alert erreur">🚫 <?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div class="topbar">
	<h1>Caisse</h1>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem; align-items: start;">

	<div class="table-wrapper">
		<table>
			<thead>
				<tr>
					<th>Produit</th>
					<th>Catégorie</th>
					<th>Prix vente</th>
					<th>Stock</th>
					<th>Quantité</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($products)): ?>
					<tr>
						<td colspan="5" class="vide">Aucun produit disponible.</td>
					</tr>
				<?php else: ?>
					<?php foreach ($products as $p): ?>
						<tr class="<?= $p->isLowStock() ? 'row-alerte' : '' ?>">
							<td><?= htmlspecialchars($p->getNom()) ?></td>
							<td><span class="badge badge-cat"><?= htmlspecialchars($p->nomCategorie ?? '—') ?></span></td>
							<td><?= number_format($p->getPrixVente(), 2) ?> MAD</td>
							<td>
								<span class="badge <?= $p->isLowStock() ? 'badge-alerte' : 'badge-ok' ?>">
									<?= $p->getQuantiteStock() ?>
								</span>
							</td>
							<td>
								<input
									type="number"
									min="0"
									max="<?= $p->getQuantiteStock() ?>"
									value="0"
									style="width: 80px;"
									id="qty-<?= $p->getId() ?>"
									onchange="updatePanier(<?= $p->getId() ?>, <?= $p->getPrixVente() ?>)"
								>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="card" style="position: sticky; top: 2rem;">
		<h2 style="font-size: 1.1rem; color: #1a1a2e; border-left: 4px solid #e94560; padding-left: 0.75rem; margin-bottom: 1.25rem;">Panier</h2>

		<div id="panier-vide" style="color: #888; font-size: 0.9rem; margin-bottom: 1rem;">Aucun article sélectionné.</div>

		<div id="panier-lignes" style="margin-bottom: 1rem;"></div>

		<div style="border-top: 1px solid #f0f0f0; padding-top: 0.75rem; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
			<span style="font-weight: 600; color: #1a1a2e;">Total TTC</span>
			<span id="total-ttc" style="font-size: 1.3rem; font-weight: 700; color: #e94560;">0.00 MAD</span>
		</div>

		<form method="POST" action="index.php?page=sale-validate" id="form-caisse">
			<div id="panier-inputs"></div>
			<button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem;" id="btn-valider" disabled>
				Valider la vente
			</button>
		</form>
	</div>
</div>

<style>
	tr.row-alerte td {
		background: #fff9f9;
	}
</style>

<script>
	const panier = {};

	function updatePanier(id, prix) {
		const qty = parseInt(document.getElementById('qty-' + id).value) || 0;

		if (qty > 0) {
			panier[id] = {qty: qty, prix: prix};
		} else {
			delete panier[id];
		}

		renderPanier();
	}

	function renderPanier() {
		const lignesDiv = document.getElementById('panier-lignes');
		const inputsDiv = document.getElementById('panier-inputs');
		const totalSpan = document.getElementById('total-ttc');
		const btnValider = document.getElementById('btn-valider');
		const panierVide = document.getElementById('panier-vide');

		lignesDiv.innerHTML = '';
		inputsDiv.innerHTML = '';

		let total = 0;

		for (const [id, data] of Object.entries(panier)) {
			const sousTotal = data.qty * data.prix;
			total += sousTotal;

			lignesDiv.innerHTML += `
				<div style="display: flex; justify-content: space-between; font-size: 0.88rem; margin-bottom: 0.4rem; color: #333;">
					<span>${data.qty} x ${data.prix.toFixed(2)} MAD</span>
					<span>${sousTotal.toFixed(2)} MAD</span>
				</div>
			`;

			inputsDiv.innerHTML += `<input type="hidden" name="panier[${id}]" value="${data.qty}">`;
		}

		const vide = Object.keys(panier).length === 0;
		panierVide.style.display = vide ? 'block' : 'none';
		lignesDiv.style.display = vide ? 'none' : 'block';
		totalSpan.textContent = total.toFixed(2) + ' MAD';
		btnValider.disabled = vide;
	}
</script>
