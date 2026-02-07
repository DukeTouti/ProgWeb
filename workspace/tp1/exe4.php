<?php

const COEFF_CC = 0.2;
const COEFF_TP = 0.2;
const COEFF_EXAM = 0.6;

$etudiants = [
	"Ahmed" => [14, 16, 10],
	"Salma" => [18, 19, 17],
	"Karim" => [5, 12, 8],
	"Nora" => [12, 11, 13]
];

echo "<h2>Contenu du tableau</h2>";
echo "<pre>";
print_r($etudiants);
echo "</pre>";


echo "<h2>Bulletin de notes</h2>";


foreach ($etudiants as $nom => $notes) {
	$moyenne = ($notes[0] * COEFF_CC) + ($notes[1] * COEFF_TP) + ($notes[2] * COEFF_EXAM);
	
	if ($moyenne < 10) {
		$status = "Recalé";
		$couleur = "red";
	} elseif ($moyenne >= 12) {
		$status = "Bien";
		$couleur = "green";
	} else {
		$status = "Passable";
		$couleur = "orange";
	}
	
	if ($notes[2] < 6) {
		$status = "Recalé";
		$couleur = "red";
	}
	
	echo "<p>$nom - Moyenne: " . $moyenne . " - ";
	echo "<span style='color: $couleur; font-weight: bold;'>$status</span></p>";
}



?>
