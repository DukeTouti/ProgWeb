<div class="topbar">
	<h1>Utilisateurs</h1>
	<a href="index.php?page=user-add" class="btn btn-primary">+ Ajouter un utilisateur</a>
</div>

<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Login</th>
				<th>Rôle</th>
				<th>Créé le</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($users)): ?>
				<tr>
					<td colspan="6" class="vide">Aucun utilisateur trouvé.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($users as $u): ?>
					<tr>
						<td><?= htmlspecialchars($u->getNom()) ?></td>
						<td><?= htmlspecialchars($u->getPrenom()) ?></td>
						<td><?= htmlspecialchars($u->getLogin()) ?></td>
						<td><span class="badge-role <?= htmlspecialchars($u->getRole()) ?>"><?= htmlspecialchars($u->getRole()) ?></span></td>
						<td style="color: #888; font-size: 0.85rem;"><?= htmlspecialchars($u->getCreatedAt()) ?></td>
						<td class="actions">
							<a href="index.php?page=user-edit&id=<?= $u->getId() ?>" class="btn btn-secondary">Modifier</a>
							<a href="index.php?page=user-delete&id=<?= $u->getId() ?>" class="btn btn-danger" onclick="return confirm('Supprimer « <?= htmlspecialchars($u->getLogin(), ENT_QUOTES) ?> » ?')">Supprimer</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
