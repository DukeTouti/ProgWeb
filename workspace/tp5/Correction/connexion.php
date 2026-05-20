<?php

function getConnexion(): PDO {
    $host = 'localhost';
    $dbname = 'cinemabd';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    return $pdo;
}