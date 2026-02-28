<?php

include "utilisateur.php";
include "administrateur.php";

$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : '';
$login = isset($_POST['login']) ? $_POST['login'] : '';
$mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : 'Utilisateur';
$preferences = isset($_POST['preferences']) ? $_POST['preferences'] : [];
$permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

if ($type === 'Administrateur') {
	$compte = new Administrateur($nom, $email, $genre, $login, $mdp, $preferences, $description, $permissions);
	$compte->afficherInfos("Infos Administrateur");
} else {
	$compte = new Utilisateur($nom, $email, $genre, $login, $mdp, $preferences, $description);
	$compte->afficherInfos("Infos Utilisateur");
}

?>
