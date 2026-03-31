<?php

function getConnexion() : PDO {
	$host   = 'localhost';
	$dbname = 'GestionMagasin';
	$user   = 'magasin';
	$pass   = 'magasin123';

	$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $pdo;
}

?>
