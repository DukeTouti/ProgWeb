<?php
// connexion.php - Connexion PDO centralisee (inchange depuis TP5)
$host   = 'localhost';
$dbname = 'CinemaBD';
$user   = 'root';
$pass   = '';
$dsn    = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
