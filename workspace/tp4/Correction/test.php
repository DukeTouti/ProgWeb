<?php
include "Utilisateur.php";
include "Administrateur.php";

$user = new Utilisateur("Durant", "durant@uir.ac.ma", "M",
    "monLogin", "1234",
    ["GameDev", "DevOps"], "Hello world description");


$admin = new Administrateur("Durant", "durant@uir.ac.ma", "M","monLogin", "1234",
                                ["GameDev", "DevOps"], "Hello world description", ["gest user","gest Prods" ]);

echo "<br> <h3> Infos Utilisateur simple  ============================================ </h3>";
echo $user;

echo "<br> <h3> Infos administrateur ============================================ </h3>";
echo $admin;
