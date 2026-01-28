<?php

echo "=================================================<br>";
echo "    EXERCICE PHP - MANIPULATION DE TABLEAUX    <br>";
echo "=================================================<br><br>";

// Tableau de test
$tableau = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

echo "Tableau de test : [" . implode(", ", $tableau) . "]<br>";
echo "Taille : " . count($tableau) . " éléments<br><br>";

// ========================================
// EXERCICE 1 : SOMME
// ========================================
echo "=================================================<br>";
echo "EXERCICE 1 : SOMME DE TOUS LES NOMBRES<br>";
echo "=================================================<br><br>";

// Méthode 1 : array_sum()
$somme1 = array_sum($tableau);
echo "Méthode 1 - array_sum() :<br>";
echo "Résultat : " . $somme1 . "<br><br>";

// Méthode 2 : foreach (universelle)
$somme2 = 0;
foreach ($tableau as $val) {
    $somme2 += $val;
}
echo "Méthode 2 - foreach (fonctionne avec n'importe quelle taille, plus pratique dans les cas où la taille est inconnue) :<br>";
echo "Résultat : " . $somme2 . "<br><br>";

// Méthode 3 : for classique
$somme3 = 0;
for ($i = 0; $i < count($tableau); $i++) {
    $somme3 += $tableau[$i];
}
echo "Méthode 3 - for (nécessite de connaître la taille) :<br>";
echo "Résultat : " . $somme3 . "<br><br>";

// ========================================
// EXERCICE 2 : MAX, MIN, MOYENNE
// ========================================
echo "=================================================<br>";
echo "EXERCICE 2 : MAXIMUM, MINIMUM ET MOYENNE<br>";
echo "=================================================<br><br>";

// ===== MAXIMUM =====
echo "----- MAXIMUM -----<br><br>";

// Max - Méthode 1 : max()
$max1 = max($tableau);
echo "Méthode 1 - Fonction max() :<br>";
echo "Résultat : " . $max1 . "<br><br>";

// Max - Méthode 2 : foreach
$max2 = $tableau[0];
foreach ($tableau as $val) {
    if ($val > $max2) {
        $max2 = $val;
    }
}
echo "Méthode 2 - Boucle foreach :<br>";
echo "Résultat : " . $max2 . "<br><br>";

// Max - Méthode 3 : sort() puis end()
$tableau_trie_max = $tableau;
sort($tableau_trie_max);
$max3 = end($tableau_trie_max);
echo "Méthode 3 - Sort puis end() (prendre le dernier élément du tableau) :<br>";
echo "Résultat : " . $max3 . "<br><br>";

// Max - Méthode 4 : rsort() puis premier élément
$tableau_trie_max2 = $tableau;
rsort($tableau_trie_max2);
$max4 = $tableau_trie_max2[0];
echo "Méthode 4 - Rsort puis premier élément (prendre le premier élément du tableau) :<br>";
echo "Résultat : " . $max4 . "<br><br>";

// ===== MINIMUM =====
echo "----- MINIMUM -----<br><br>";

// Min - Méthode 1 : min()
$min1 = min($tableau);
echo "Méthode 1 - Fonction min() :<br>";
echo "Résultat : " . $min1 . "<br><br>";

// Min - Méthode 2 : foreach
$min2 = $tableau[0];
foreach ($tableau as $val) {
    if ($val < $min2) {
        $min2 = $val;
    }
}
echo "Méthode 2 - Boucle foreach :<br>";
echo "Résultat : " . $min2 . "<br><br>";

// Min - Méthode 3 : sort() puis premier élément
$tableau_trie_min = $tableau;
sort($tableau_trie_min);
$min3 = $tableau_trie_min[0];
echo "Méthode 3 - Sort puis premier élément (prendre le premier élément du tableau) :<br>";
echo "Résultat : " . $min3 . "<br><br>";

// Min - Méthode 4 : rsort() puis end()
$tableau_trie_min2 = $tableau;
rsort($tableau_trie_min2);
$min4 = end($tableau_trie_min2);
echo "Méthode 4 - Rsort puis end() (prendre le dernier élément du tableau) :<br>";
echo "Résultat : " . $min4 . "<br><br>";

// ===== MOYENNE =====
echo "----- MOYENNE -----<br><br>";

// Moyenne - Méthode 1 : array_sum() / count()
$moyenne1 = array_sum($tableau) / count($tableau);
echo "Méthode 1 - array_sum() / count() :<br>";
echo "Résultat : " . round($moyenne1, 2) . "<br><br>";

// Moyenne - Méthode 2 : foreach + sizeof()
$somme_moyenne = 0;
foreach ($tableau as $val) {
    $somme_moyenne += $val;
}
$moyenne2 = $somme_moyenne / sizeof($tableau);
echo "Méthode 2 - Foreach + sizeof() :<br>";
echo "Résultat : " . round($moyenne2, 2) . "<br><br>";

?>

