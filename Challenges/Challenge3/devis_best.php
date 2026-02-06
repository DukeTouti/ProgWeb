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
	
	// Affichage du résultat avec style
	echo '<div style="background: rgba(255,255,255,0.95); padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); color: #333;">';
	echo '<h2 style="color: #667eea; text-align: center; font-size: 2.5em; margin-bottom: 30px;">Résultat du Devis</h2>';
	
	echo '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 15px; text-align: center; font-size: 1.3em;">';
	echo '<p style="margin-bottom: 20px; font-size: 1.2em;">Bonjour <strong>' . $nom . '</strong>,</p>';
	echo '<p style="font-size: 2em; margin: 20px 0;"><strong>' . $total . ' DH</strong></p>';
	echo '<p>Pour <strong>' . $duree . ' jour(s)</strong> de location</p>';
	echo '</div>';
	
	// Détails
	echo '<div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">';
	echo '<h3 style="color: #667eea; margin-bottom: 15px;">Détails de la réservation :</h3>';
	echo '<ul style="list-style: none; padding: 0;">';
	echo '<li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>Modèle :</strong> ' . ucfirst($modele) . '</li>';
	echo '<li style="padding: 8px 0; border-bottom: 1px solid #ddd;"><strong>Durée :</strong> ' . $duree . ' jour(s)</li>';
	
	if (!empty($options)) {
		echo '<li style="padding: 8px 0;"><strong>Options :</strong></li>';
		echo '<ul style="margin-left: 30px; margin-top: 10px;">';
		foreach ($options as $opt) {
			if ($opt == "gps") {
				echo '<li>GPS (+50 DH/jour)</li>';
			} elseif ($opt == "siege") {
				echo '<li>Siège Enfant (+30 DH/jour)</li>';
			} elseif ($opt == "assurance") {
				echo '<li>Assurance Tous Risques (+100 DH/jour)</li>';
			}
		}
		echo '</ul>';
	} else {
		echo '<li style="padding: 8px 0;"><strong>Options :</strong> Aucune</li>';
	}
	
	echo '</ul>';
	echo '</div>';
	
	echo '<div style="text-align: center; margin-top: 30px;">';
	echo '<a href="devis.html" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 40px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 1.1em;">← Nouveau devis</a>';
	echo '</div>';
	
	echo '</div>';
	
} else {
	// Afficher le formulaire avec style
	echo '<div style="background: rgba(255,255,255,0.95); padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); color: #333;">';
	echo '<h2 style="color: #667eea; text-align: center; font-size: 2.5em; margin-bottom: 30px;">Configurez votre location</h2>';
	
	echo '<form method="POST" action="devis.php" style="max-width: 600px; margin: 0 auto;">';
	
	// Nom
	echo '<div style="margin-bottom: 25px;">';
	echo '<label style="display: block; font-weight: bold; margin-bottom: 8px; color: #555; font-size: 1.1em;">Nom du client :</label>';
	echo '<input type="text" name="nom" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1em; transition: border-color 0.3s;" onfocus="this.style.borderColor=\'#667eea\'" onblur="this.style.borderColor=\'#ddd\'">';
	echo '</div>';
	
	// Modèle
	echo '<div style="margin-bottom: 25px;">';
	echo '<label style="display: block; font-weight: bold; margin-bottom: 12px; color: #555; font-size: 1.1em;">Modèle de voiture :</label>';
	echo '<div style="margin-left: 15px;">';
	echo '<label style="display: block; margin-bottom: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="radio" name="modele" value="citadine" required style="margin-right: 10px;"> Citadine (300 DH/jour)</label>';
	echo '<label style="display: block; margin-bottom: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="radio" name="modele" value="berline" style="margin-right: 10px;"> Berline (500 DH/jour)</label>';
	echo '<label style="display: block; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="radio" name="modele" value="4x4" style="margin-right: 10px;"> 4x4 (800 DH/jour)</label>';
	echo '</div>';
	echo '</div>';
	
	// Durée
	echo '<div style="margin-bottom: 25px;">';
	echo '<label style="display: block; font-weight: bold; margin-bottom: 8px; color: #555; font-size: 1.1em;">Durée (jours) :</label>';
	echo '<input type="number" name="duree" min="1" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1em; transition: border-color 0.3s;" onfocus="this.style.borderColor=\'#667eea\'" onblur="this.style.borderColor=\'#ddd\'">';
	echo '</div>';
	
	// Options
	echo '<div style="margin-bottom: 30px;">';
	echo '<label style="display: block; font-weight: bold; margin-bottom: 12px; color: #555; font-size: 1.1em;">Options supplémentaires :</label>';
	echo '<div style="margin-left: 15px;">';
	echo '<label style="display: block; margin-bottom: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="checkbox" name="options[]" value="gps" style="margin-right: 10px;"> GPS (+50 DH/jour)</label>';
	echo '<label style="display: block; margin-bottom: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="checkbox" name="options[]" value="siege" style="margin-right: 10px;"> Siège Enfant (+30 DH/jour)</label>';
	echo '<label style="display: block; padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background=\'#e9ecef\'" onmouseout="this.style.background=\'#f8f9fa\'"><input type="checkbox" name="options[]" value="assurance" style="margin-right: 10px;"> Assurance Tous Risques (+100 DH/jour)</label>';
	echo '</div>';
	echo '</div>';
	
	// Bouton
	echo '<button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1.2em; font-weight: bold; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform=\'scale(1.02)\'" onmouseout="this.style.transform=\'scale(1)\'">Calculer le devis</button>';
	
	echo '</form>';
	echo '</div>';
}
?>
