<?php
$etudiants = [
	"Sami" => 15.5,
	"Yahya" => 18,
	"Miti" => 9.5,
	"Anais" => 12,
	"Martin" => 14
];


echo "<h2>Contenu du tableau</h2>";
echo "<pre>";
print_r($etudiants);
echo "</pre>";


echo "<h2>Recherche d'un étudiant</h2>";
$recherche = "Yahya";
if (isset($etudiants[$recherche])) {
	echo "$recherche est présent(e) avec une moyenne de " . $etudiants[$recherche];
} else {
	echo "$recherche n'est pas trouvé(e)";
}


echo "<h2>Étudiants ayant validé (moyenne >= 12)</h2>";
foreach ($etudiants as $nom => $moyenne) {
	if ($moyenne >= 12) {
		echo "$nom : $moyenne<br>";
	}
}
?>
