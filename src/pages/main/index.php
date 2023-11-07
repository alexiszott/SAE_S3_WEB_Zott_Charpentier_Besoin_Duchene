<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Touiteur</title>
<link rel="stylesheet" href="../../css/touit.css">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
<header>
    <h1>TOUITEUR</h1>
    <div class="menu navigation">
        <a href="index.php"><p>Profile</p></a>
        <a href="index.php"><p>Accueil</p></a>
    </div>
    <div class="menu connexion">
        <a href="?action=signin"><p>Se connecter</p></a>
        <a href="?action=signup"><p>S'inscrire</p></a>
    </div>
    <label>
        <input type="text" placeholder="Rechercher..">
    </label>
</header>
<body>
<div class="touite">
    <div class="infos">
        <p>Alexis</p>
        <p>Zott</p>
    </div>
    <div class="date">
        <p>07 / 11 / 2023</p>
    </div>
    <div class="message">
        <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et
            la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis l
            es années 1500, quand un imprimeur anonyme assembl
            a ensemble des morceaux de texte pour réaliser un livre .</p>
    </div>
    <div class="interaction">
        <p>LIKE</p>
        <p>DISLIKE</p>
    </div>
</div>

<?php

require_once '../../../vendor/autoload.php';

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\dispatch\Dispatcher;
session_start();

if(!isset($_GET['action'])){
    $_GET['action'] = "TouiteDisplay";
}

ConnexionFactory::setConfig('../classes/conf/config.ini');

$d = new Dispatcher();
$d->run();
//TODO


?>
</body>
</html>

