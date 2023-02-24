<?php


$host = 'localhost';
$port = 3306;
$base = 'talis_rubik';
$user = 'root';
$pass = '';

$charset = 'utf8mb4';

// Configuration interne de Oressource
try {
  $bdd = new PDO("mysql:host=$host;port=$port;dbname=$base;charset=$charset", $user, $pass, [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_DIRECT_QUERY => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_STRINGIFY_FETCHES => false,
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
} catch (PDOException $e) {
  http_response_code(500); // Internal server error
  echo ("<!DOCTYPE html>
  <html>
  <head>
  <meta encoding='utf8'/>
  </head>
  <body>  
  <h1>500 Erreur interne</h1>
  <p>Échec de la connection à la base de donnée, contactez votre administrateur il y a un soucis.<p>
  <p>Une fois le problème résolu vous pouvez recharger la page avec F5 ou la séquence Ctrl-alt-R.</p>
  </body>
  </html>");
  die('Error : Impossible de dialoguer avec la database. ' . $e->getMessage());
}
global $bdd;
