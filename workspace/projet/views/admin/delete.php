<div class="topbar">
	<h1>Suppression</h1>
</div>

<div class="card" style="max-width: 420px; text-align: center;">
	<div class="alert <?= $erreur ? 'erreur' : 'succes' ?>">
		<?= htmlspecialchars($message) ?>
	</div>

	<a href="index.php?page=<?= $retour ?>" class="btn btn-primary">← Retour</a>
</div>
