<?php

global $bdd;

require_once('../api/requete.php');
require_once('dbconfig.php');

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$nom = checkInput($_POST['nom']);
$prenom = checkInput($_POST['prenom']);
$mail = checkInput($_POST['email']);
$password = checkInput($_POST['pass']);

if (empty($mail) || empty($password) || empty($nom) || empty($prenom)) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Donnees manquantes !'], JSON_FORCE_OBJECT);
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $id = utilisateur_insert($bdd, ['nom' => $nom, 'prenom' => $prenom, 'mail' => $mail, 'password' => $hashed_password]);
    session_start();
    $_SESSION['user_id'] = $id;
    $_SESSION['user_nom'] = $nom;
    $_SESSION['user_prenom'] = $prenom;
    http_response_code(200); // OK
    echo json_encode(['status' => 'OK'], JSON_FORCE_OBJECT);
    header('Location: ../index.php');
}
