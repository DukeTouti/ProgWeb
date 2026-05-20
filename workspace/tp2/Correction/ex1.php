<?php
// Compteur global pour les matricules
$compteur = 1000;

// Passage par référence pour le compteur
function genererMatricule($prenom, $nom, &$compteur) {
    // 1ere lettre du prénom + nom + compteur
    $premiereLettre = substr($prenom, 0, 1);
    $matricule = strtoupper($premiereLettre . $nom . $compteur);
    
    // Incrementation du compteur pour le prochain étudiant
    $compteur++;
    
    return $matricule;
}

echo genererMatricule("Saad", "Noufel", $compteur) . "<br>"; // SNOUFEL1000
echo genererMatricule("Mehdi", "Najib", $compteur) . "<br>";    // MNAJIB1001
echo genererMatricule("Ayoub", "Akhdam", $compteur) . "<br>";    // AAKHDAM1002
?>