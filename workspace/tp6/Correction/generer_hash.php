<?php
// generer_hash.php
// Executer ce script UNE SEULE FOIS pour obtenir le hash a copier dans phpMyAdmin
// Puis supprimer ce fichier du projet.

$motDePasse = "cinema2025";
$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

echo "<pre>";
echo "Mot de passe clair : $motDePasse\n";
echo "Hash bcrypt        : $hash\n";
echo "</pre>";
echo "<p>Copiez le hash ci-dessus dans votre requete SQL INSERT.</p>";
