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
    $titre = checkInput($_POST['titre']);
    $categorie = checkInput($_POST['categorie']);
    $description = checkInput($_POST['description']);

    if (empty($_FILES['image']) || empty($description) || empty($titre) || empty($categorie)) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Donnees manquantes !'], JSON_FORCE_OBJECT);
    } else {
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $infoImage = pathinfo($image);
        $extImage = $infoImage['extension'];
        $nameImage = $infoImage['filename'];
        $uniqueName = $nameImage . time() . rand(1, 1000) . '.' . $extImage;
        move_uploaded_file($imageTmp, '../public/img/article/' . $uniqueName);
        $user_id = $_SESSION['user_id'];
        article_insert($bdd, ['titre' => $titre, 'categorie_id' => $categorie, 'description' => $description, 'image' => $uniqueName, 'user_id' => $user_id]);
        http_response_code(200); // OK
        echo json_encode(['status' => 'OK'], JSON_FORCE_OBJECT);
        header('Location: ../views/collections.php');
    }
} else {
    header('Location:../moteur/destroy.php');
}
