<form action="ex4.php" method="POST">
	<label>Nom</label>
	<input type="text" name="nom" required><br>
	
	<label>Prénom</label>
	<input type="text" name="prenom" required><br>
	
	<label>Années d'expérience:</label>
	<select name="experience" required>
		<option value="0-2">0-2 ans</option>
		<option value="3-5">3-5 ans</option>
		<option value="+5">+5 ans</option>
	</select><br>
	
	<label>Compétences:</label>
	<input type="checkbox" name="competences[]" value="PHP"> PHP
	<input type="checkbox" name="competences[]" value="SQL"> SQL
	<input type="checkbox" name="competences[]" value="Python"> Python
	<input type="checkbox" name="competences[]" value="HTML/CSS"> HTML/CSS
	<input type="checkbox" name="competences[]" value="Java"> Java<br><br>
	
	<button type="submit">Évaluer le candidat</button>
</form>



<?php

function calculerScore($experience, $competences) {
	$score = 0;
	
	
	if ($experience == "0-2") $score += 0;
	elseif ($experience == "3-5") $score += 10;
	elseif ($experience == "+5") $score += 20;
	
	
	foreach ($competences as $competence) {
		if ($competence == "PHP") $score += 5;
		elseif ($competence == "Python") $score += 5;
		elseif ($competence == "SQL") $score += 5;
		elseif ($competence == "Java") $score += 2;
	}
	
	return $score;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$experience = $_POST['experience'];
	$competences = isset($_POST['competences']) ? $_POST['competences'] : [];
	
	$score = calculerScore($experience, $competences);
	
	echo "<h3>Évaluation de $prenom $nom</h3>";
	echo "Expérience: $experience ans<br>";
	echo "Compétences: " . (count($competences) > 0 ? implode(", ", $competences) : "Aucune") . "<br>";
	echo "<strong>Score Total: $score points</strong><br><br>";
	
	
	if ($score >= 20) {
		echo "<div style='background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px;'>";
		echo "<strong>Candidat Retenu</strong>";
		echo "</div>";
	} else {
		echo "<div style='background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px;'>";
		echo "<strong>Candidat Rejeté</strong>";
		echo "</div>";
	}
}

?>
