<?php

echo "=================================================<br>";
echo "    EXERCICE PHP - GESTION PANIER E-COMMERCE    <br>";
echo "=================================================<br><br>";

// Panier du client : [Produit => [Prix Unitaire, Quantité]]
$panier = [
    "Clavier" => [400, 1],
    "Souris Sans Fil" => [150, 3],
    "Clé USB 64Go" => [100, 2]
];

echo "CONTENU DU PANIER<br>";
echo "-------------------------------------------------<br>";
foreach ($panier as $produit => $details) {
    echo "- " . $produit . " : " . $details[1] . " x " . $details[0] . " Dhs<br>";
}
echo "<br>";

// ========================================
// ÉTAPE 1 : CALCUL DU SOUS-TOTAL
// ========================================
echo "=================================================<br>";
echo "ÉTAPE 1 : CALCUL DU SOUS-TOTAL<br>";
echo "=================================================<br><br>";

$total = 0;

echo "Détail du calcul :<br>";
echo "-------------------------------------------------<br>";
foreach ($panier as $produit => $details) {
    $prixUnitaire = $details[0];
    $quantite = $details[1];
    $montantProduit = $prixUnitaire * $quantite;
    $total += $montantProduit;
    
    echo "- " . $produit . " : " . $quantite . " × " . $prixUnitaire . " Dhs = " . $montantProduit . " Dhs<br>";
}

echo "<br>TOTAL À PAYER : " . $total . " Dhs<br><br>";

// ========================================
// ÉTAPE 2 : APPLICATION DE LA REMISE
// ========================================
echo "=================================================<br>";
echo "ÉTAPE 2 : APPLICATION DE LA REMISE<br>";
echo "=================================================<br><br>";

$montantRemise = 0;
$montantApresRemise = $total;

if ($total > 500) {
    $montantRemise = $total * 0.10;
    $montantApresRemise = $total - $montantRemise;
    
    echo "Le total à payer (" . $total . " Dhs) dépasse 500 Dhs<br>";
    echo "Remise de 10% appliquée !<br><br>";
    echo "Calcul de la remise :<br>";
    echo "-------------------------------------------------<br>";
    echo "- Total : " . $total . " Dhs<br>";
    echo "- Remise (10%) : -" . $montantRemise . " Dhs<br>";
    echo "- Montant après remise : " . $montantApresRemise . " Dhs<br><br>";
} else {
    echo "Le Total à payer (" . $total . " Dhs) ne dépasse pas 500 Dhs<br>";
    echo "Aucune remise appliquée.<br><br>";
}

// ========================================
// ÉTAPE 3 : AJOUT DE LA TVA
// ========================================
echo "=================================================<br>";
echo "ÉTAPE 3 : AJOUT DE LA TVA (20%)<br>";
echo "=================================================<br><br>";

$montantTVA = $montantApresRemise * 0.20;
$montantFinal = $montantApresRemise + $montantTVA;

echo "Calcul de la TVA :<br>";
echo "-------------------------------------------------<br>";
echo "- Montant HT : " . $montantApresRemise . " Dhs<br>";
echo "- TVA (20%) : +" . $montantTVA . " Dhs<br>";
echo "- Montant TTC : " . $montantFinal . " Dhs<br><br>";

// ========================================
// ÉTAPE 4 : RÉCAPITULATIF FINAL
// ========================================
echo "=================================================<br>";
echo "RÉCAPITULATIF DE LA COMMANDE<br>";
echo "=================================================<br><br>";

echo "LISTE DES PRODUITS :<br>";
echo "-------------------------------------------------<br>";
foreach ($panier as $produit => $details) {
    $prixUnitaire = $details[0];
    $quantite = $details[1];
    $montantProduit = $prixUnitaire * $quantite;
    
    echo "- " . $produit . "<br>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Quantité : " . $quantite . " | Prix unitaire : " . $prixUnitaire . " Dhs | Total : " . $montantProduit . " Dhs<br>";
}

echo "<br>";
echo "-------------------------------------------------<br>";
echo "DÉTAILS DU MONTANT :<br>";
echo "-------------------------------------------------<br>";
echo "Sous-total : " . $total . " Dhs<br>";

if ($montantRemise > 0) {
    echo "Remise (10%) : -" . $montantRemise . " Dhs<br>";
}

echo "TVA (20%) : +" . $montantTVA . " Dhs<br>";
echo "<br>";
echo "MONTANT FINAL À PAYER : " . $montantFinal . " Dhs<br>";

?>
