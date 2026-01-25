<?php
// connexion.php
$host = 'localhost';
$dbname = 'bd_emplois';
$username = 'root';
$password = 'benji123';

// Connexion MySQLi
$db = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($db->connect_error) {
    die("Erreur de connexion : " . $db->connect_error);
}

// Définir le charset UTF-8
$db->set_charset("utf8");

// Variable globale pour compatibilité
$GLOBALS['db'] = $db;
