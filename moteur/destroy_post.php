<?php

global $bdd;
session_start();
require_once('../api/requete.php');
require_once('dbconfig.php');

$articleById = [];
$id = $_GET['id'];
if (preg_match('#^([0-9]+)$#', $id, $matches)) {
    $id = intval($matches[1]);
    $articleById = articleById($bdd, $id);
}
if (isset($_SESSION['user_id']) && !empty($articleById) && $_SESSION['user_id'] === $articleById['user_id']) {
    $image = articleById($bdd, $id)['image'];
    unlink('../public/img/article/' . $image);
    deleteArticleById($bdd, $id);
    header('Location:../views/collections.php');
} else {
    header('Location:../views/login.php');
}
