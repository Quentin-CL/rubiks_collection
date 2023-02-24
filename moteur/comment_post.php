<?php

global $bdd;
session_start();
require_once('../api/requete.php');


function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SESSION['user_id'])) {
    require_once('dbconfig.php');
    $commentaire = checkInput($_POST['commentaire']);
    $rating = checkInput($_POST['rating']);
    $article_id = checkInput($_POST['article_id']);

    if (empty($rating)) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Donnees manquantes !'], JSON_FORCE_OBJECT);
    } else {
        $user_id = $_SESSION['user_id'];
        commentaireInsert($bdd, ['article_id' => $article_id, 'rating' => $rating, 'commentaire' => $commentaire, 'user_id' => $user_id]);
        http_response_code(200); // OK
        echo json_encode(['status' => 'OK'], JSON_FORCE_OBJECT);
        header('Location: ../views/show.php?id=' . $article_id);
    }
} else {
    header('Location:../views/login.php');
}
