<?php

$prixPC_ht = 10000;
$tva = 0.2;
$nbre = 5; // nombre de PC achetés, vous pouvez le modifier pour tester avec différentes quantités

// Calcul du prix hors taxes
$total_ht = $prixPC_ht * $nbre;

// Calcul du prix TTC
$total_ttc = $total_ht * (1 + $tva); // ou $total_ttc = $total_ht + ($total_ht * $tva);

echo "Le prix total toutes taxes comprises pour $nbre PC est : " . $total_ttc . " MAD<br>";