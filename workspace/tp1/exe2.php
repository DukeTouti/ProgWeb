<?php

$tbl = array (2, 4, 6, 8, 10);

echo "Voici le tableau utilisé : ";

for ($i = 0 ; $i < count($tbl) ; $i++) {
	if ($i == 0) {
		echo "[" . $tbl[$i];
	} elseif ($i > 0 && $i < (count($tbl) -1) ) {
		echo ", " . $tbl[$i];
	} else {
		echo ", " . $tbl[$i] . "]<br/><br/>";
	}
}

echo "Le maximum est : " . max($tbl);
echo "<br/><br/>Le minimum est : " . min($tbl);
echo "<br/><br/>La moyenne est de : " . array_sum($tbl) / count($tbl);

$tbl_decroissant = $tbl;
rsort($tbl_decroissant);
echo "<br/><br/>Voici le tableau trié dans l'ordre décroissant : [" . implode(", ", $tbl_decroissant) . "]";

?>
