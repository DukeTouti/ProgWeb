<?php

$taille = $_GET['taille'];
$poids = $_GET['poids'];

function calculerIMC ($poids, $taille) {
	
	$imc = $poids / power($taille, 2);
	
	return $imc;
}

function interpreter ($imc) {
	if ($imc < 18.5) return "Maigreur";
	if (18.5 <= $imc && $imc < 25) return "Normale";
	if (25 <= $imc && $imc < 30) return "Surpoids";
	return "Obésité";
}

?>
