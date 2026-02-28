<?php

include "utilisateur.php";
include "administrateur.php";

$user = new Utilisateur("Gros", "gr.os@etu.univ-grenoble-alpes.fr", "M", "log1", "test12", ["GameDev", "DevOps"], "Bonjour");

$admin = new Administrateur("Kabore", "kab.ore@etu.univ-grenoble-alpes.fr", "M", "kaborem", "sharif", ["GameDev", "DevOps"], "Bonjour", 
			    ["gest user", "gest prods"]);
			    
echo "<br> <h3> Infos Utilisateur simple ================================================================= </h3>";
echo $user;
$user->afficherInfos("Infos Utilisateur");
echo "</br>";

echo "<br> <h3> Infos Administrateur simple ============================================================== </h3>";
echo $admin;
$admin->afficherInfos("Infos Admin");

?>
