<div class="topbar">
	<h1>Suppression de produit</h1>
</div>

<div class="card" style="max-width: 420px; text-align: center;">
	<div class="alert <?= $erreur ? 'erreur' : 'succes' ?>">
		<?= htmlspecialchars($message) ?>
	</div>

	<a href="index.php?page=products" class="btn btn-primary">← Retour aux produits</a>
</div>
