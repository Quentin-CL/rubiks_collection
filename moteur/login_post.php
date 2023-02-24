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

$mail = checkInput($_POST['email']);
$password = checkInput($_POST['pass']);

if (empty($mail) || empty($password)) {
    echo "Nom d'utilisateur et/ou mot de passe manquant(s).";
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $row = login($bdd, $mail);
    if ($row && password_verify($password, $row[0]['password'])) {
        session_start();
        $_SESSION['user_id'] = $row[0]['id'];
        $_SESSION['user_nom'] = $row[0]['nom'];
        $_SESSION['user_prenom'] = $row[0]['prenom'];
        http_response_code(200); // OK
        echo json_encode(['status' => 'OK'], JSON_FORCE_OBJECT);
        header('Location: ../index.php');
    } else {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Mauvais identifiant ou mot de passe !'], JSON_FORCE_OBJECT);
    }
}
