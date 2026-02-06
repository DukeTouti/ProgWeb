<?php

$prixPC_ht = 10000;
echo "Le prix d'un PC est de " . $prixPC_ht . "€";

const TVA = 0.2;
echo " <br/><br/>Avec une TVA de " . TVA*100 . "%<br/><br/>";

$nbr = 5;

$prix_ht_total = $prixPC_ht * $nbr;

$prix_ttc = $prix_ht_total * (1 + TVA);

echo "Le prix Hors Taxe de 5 PC achetés est de " . $prix_ht_total . "€";
echo "<br/>";
echo "Le prix TTC de 5 PC achetés est de " . $prix_ttc . "€";

?>
