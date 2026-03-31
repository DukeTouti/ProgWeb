<div class="topbar">
	<h1>Fournisseurs</h1>
	<a href="index.php?page=supplier-add" class="btn btn-primary">+ Ajouter un fournisseur</a>
</div>

<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Email</th>
				<th>Téléphone</th>
				<th>Compte lié</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($suppliers)): ?>
				<tr>
					<td colspan="5" class="vide">Aucun fournisseur trouvé.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($suppliers as $s): ?>
					<tr>
						<td><?= htmlspecialchars($s->getNom()) ?></td>
						<td><?= htmlspecialchars($s->getEmail() ?: '—') ?></td>
						<td><?= htmlspecialchars($s->getTelephone() ?: '—') ?></td>
						<td>
							<?php if ($s->getIdUser() > 0): ?>
								<span class="badge badge-ok">Lié</span>
							<?php else: ?>
								<span class="badge badge-cat">Non lié</span>
							<?php endif; ?>
						</td>
						<td class="actions">
							<a href="index.php?page=supplier-edit&id=<?= $s->getId() ?>" class="btn btn-secondary">Modifier</a>
							<a href="index.php?page=supplier-delete&id=<?= $s->getId() ?>" class="btn btn-danger" onclick="return confirm('Supprimer « <?= htmlspecialchars($s->getNom(), ENT_QUOTES) ?> » ?')">Supprimer</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
