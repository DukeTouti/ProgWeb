<?php

$portefeuille = [
	"Apple" => 150,
	"Tesla" => 800,
	"Bitcoin" => 40000
];

function simulerKrach($tab) {
	echo "Voici le tableau avant le crash :";
	print_r($tab);
	echo '<br>';

	foreach ($tab as $key => $val) {
		$tab[$key] = $val / 2 ;
	}
	
	echo "Le nouveau tableau apres le crash est ";
	print_r($tab);
	echo '<br>';
}

simulerKrach($portefeuille);

?>
