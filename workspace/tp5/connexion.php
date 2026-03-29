<?php

function getConnexion() : PDO {
	$host     = 'localhost';
	$dbname   = 'CinemaBD';
	$username = 'cinema';
	$password = 'cinema123';
	
	$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	return $pdo;
}
