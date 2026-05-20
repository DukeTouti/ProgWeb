<?php
// logout.php - Deconnexion et destruction de la session
session_start();
session_unset();    // Efface toutes les variables $_SESSION
session_destroy();  // Detruit la session cote serveur

// Redirection vers la page de connexion
header('Location: login.php');
exit;
