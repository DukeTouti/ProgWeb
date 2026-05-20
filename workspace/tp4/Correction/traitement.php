<?php

include "Administrateur.php";

    // recupération des champs de notre form simple des champs sans verification
    $nom = $_POST["nom"];
    $email = $_POST["email"] ;
    $genre = $_POST["genre"] ;
    $login = $_POST["login"] ;
    $password = $_POST["pwd"] ;
    $preferences = $_POST["preferences"] ;
    $description = $_POST["description"] ;
    $type = $_POST["type"] ;
    $permissions =  $_POST["permissions"]  ?? array();


    if ($type === "Administrateur") {
        $user = new Administrateur($nom, $email, $genre, $login, $password, $preferences, $description, $permissions);
        $title = "Admin";
    } else {
        $user = new Utilisateur($nom, $email, $genre, $login, $password, $preferences, $description);
        $title = "Utilisateur simple";
    }

    $user->afficherInfos($title);


?>
