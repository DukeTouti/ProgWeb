<?php

$cmp = 1000;

function genererMatricule ($prenom, $nom, &$cmp) {
	$premiereLettre = substr ($prenom, 0, 1) ;  // (prends la tout premier caractère de $prenom [0, 1[)
	
	$matricule = strtoupper ($premiereLettre . $nom . $cmp) ;
	
	$cmp++ ;
	
	return $matricule ;
}

echo genererMatricule ("Sami", "ZEFIZEF", $cmp) . "<br>" ;

echo genererMatricule ("Yahya", "FERGOUCH", $cmp) . "<br>" ;

echo genererMatricule ("Martin", "HAMON", $cmp) . "<br>" ;

?>
