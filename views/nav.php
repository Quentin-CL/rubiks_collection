<?php

require_once('../moteur/dbconfig.php');
require_once('../api/requete.php');
global $bdd;

$now_date = (new DateTime())->format('d-m-Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rubik's collection</title>
    <link rel="stylesheet" href="../public/libs/css/starability.css">
    <link rel="stylesheet" href="../public/libs/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <div class="top-bar">
        <div>
            <img src="../public/img/rubiks_logo.png" alt="">
        </div>
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <a href="./login.php" class="login-btn"><i class="fa fa-user"></i> Connexion</a>
        <?php } else { ?>
            <a href="../moteur/destroy.php" class="login-btn"><i class="fa fa-user"></i> Deconnexion</a>
        <?php } ?>
    </div>
    <nav>
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./collections.php">Collections</a></li>
            <li><a href="#">Actus</a></li>
            <li><a href="#">Contact</a></li>
            <span class="js-navbar navbar"></span>
        </ul>
    </nav>

    <script src="../public/js/navbar.js"></script>