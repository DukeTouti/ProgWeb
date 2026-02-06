<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Devis Location</title>
</head>
<body>
	<h1>Devis Location de Voiture</h1>

<?php

// Fonction pour calculer le devis
function calculerDevis($modele, $duree, $options) {
	// Prix par jour selon le modèle
	if ($modele == "citadine") {
		$prix_jour = 300;
	} elseif ($modele == "berline") {
		$prix_jour = 500;
	} else { // 4x4
		$prix_jour = 800;
	}
	
	// Prix de base
	$total = $prix_jour * $duree;
	
	// Ajouter les options
	if (!empty($options)) {
		foreach ($options as $option) {
			if ($option == "gps") {
				$total = $total + (50 * $duree);
			} elseif ($option == "siege") {
				$total = $total + (30 * $duree);
			} elseif ($option == "assurance") {
				$total = $total + (100 * $duree);
			}
		}
	}
	
	return $total;
}

// Si le formulaire est envoyé
if (isset($_POST['nom'])) {
	
	$nom = $_POST['nom'];
	$modele = $_POST['modele'];
	$duree = $_POST['duree'];
	$options = isset($_POST['options']) ? $_POST['options'] : array();
	
	$total = calculerDevis($modele, $duree, $options);
	
	echo "<h2>Résultat</h2>";
	echo "<p>Bonjour $nom, le montant total pour $duree jours est de: $total DH</p>";
	
} else {
	// Afficher le formulaire
?>

	<form method="POST">
		<p>
			<label>Nom:</label><br>
			<input type="text" name="nom" required>
		</p>
		
		<p>
			<label>Modèle:</label><br>
			<input type="radio" name="modele" value="citadine" required> Citadine (300 DH/jour)<br>
			<input type="radio" name="modele" value="berline"> Berline (500 DH/jour)<br>
			<input type="radio" name="modele" value="4x4"> 4x4 (800 DH/jour)
		</p>
		
		<p>
			<label>Durée (jours):</label><br>
			<input type="number" name="duree" min="1" required>
		</p>
		
		<p>
			<label>Options:</label><br>
			<input type="checkbox" name="options[]" value="gps"> GPS (+50 DH)<br>
			<input type="checkbox" name="options[]" value="siege"> Siège Enfant (+30 DH)<br>
			<input type="checkbox" name="options[]" value="assurance"> Assurance (+100 DH)
		</p>
		
		<button type="submit">Calculer</button>
	</form>

<?php
}
?>

</body>
</html>
