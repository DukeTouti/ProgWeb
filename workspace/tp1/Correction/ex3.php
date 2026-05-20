<?php

// Création d'un tableau associatif pour stocker les noms des étudiants et leurs notes
$etudiants = [
    "Saad" => 15,
    "Yassine" => 18,
    "Mehdi" => 20,
    "Ikram" => 16,
    "Ayoub" => 16
];

// Affichage en utilisant print_r pour voir la structure du tableau

print_r($etudiants);

// Recherche par nom si un etudiant existe et afficher sa note
$nom_recherche = "Mehdi"; // Vous pouvez changer ce nom pour tester avec d'autres étudiants

if (array_keys($etudiants, $nom_recherche)) {
    echo "La note de $nom_recherche est : " . $etudiants[$nom_recherche] . "<br>";
} else {
    echo "L'étudiant $nom_recherche n'existe pas dans le tableau.<br>";
}

// Afficher les etudiants qui ont validé le semestre (note >= 12)
echo "Les étudiants qui ont validé le semestre sont : <br>";
foreach ($etudiants as $nom => $note) {
    if ($note >= 12) {
        echo "$nom avec une note de $note<br>";
    }
}