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
    $oldImage = checkInput($_POST['oldImage']);
    $id = checkInput($_POST['articleId']);
    $voir = $_FILES['image']['size'];
    if (empty($description) || empty($titre) || empty($categorie)) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Donnees manquantes !'], JSON_FORCE_OBJECT);
    } else {
        if ($_FILES['image']['size'] !== 0) {
            unlink('../public/img/article/' . $oldImage);
            $image = $_FILES['image']['name'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $infoImage = pathinfo($image);
            $extImage = $infoImage['extension'];
            $nameImage = $infoImage['filename'];
            $uniqueName = $nameImage . time() . rand(1, 1000) . '.' . $extImage;
            move_uploaded_file($imageTmp, '../public/img/article/' . $uniqueName);
        } else {
            $uniqueName = $oldImage;
        }

        articleUpdate($bdd, $id, ['titre' => $titre, 'categorie_id' => $categorie, 'description' => $description, 'image' => $uniqueName]);
        http_response_code(200); // OK
        echo json_encode(['status' => 'OK'], JSON_FORCE_OBJECT);
        header('Location: ../views/show.php?id=' . $id);
    }
} else {
    header('Location:../moteur/destroy.php');
}
