<?php

// Initialisation d'un tableau avec 5 nombres
$tbl = [10, 20, 30, 40, 50];

// Affichage de chaque élément du tableau avec son index
for ($i = 0; $i < count($tbl); $i++) { // count($tbl) retourne la taille du tableau
    echo "L'élément à l'index $i est : " . $tbl[$i] . "<br>";
}

// Affichge du max, min, et la moyenne du tableau
$max = max($tbl);
$min = min($tbl);

for ($i = 0; $i < count($tbl); $i++) {
    $sum += $tbl[$i];
}
$moyenne = $sum / count($tbl);

// Trie du tableau en ordre decroissant
rsort($tbl);