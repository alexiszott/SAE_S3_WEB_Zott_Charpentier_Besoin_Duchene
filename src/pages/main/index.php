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
        <a href="?action=signin">Se connecter</a>
        <a href="../othersPages/signup.php">S'inscrire</a>
    </div>
    <label>
        <input type="text" placeholder="Rechercher..">
    </label>
</header>
<?php

require_once '../../../vendor/autoload.php';

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\dispatch\Dispatcher;

ConnexionFactory::setConfig('../classes/conf/config.ini');

if(!isset($_GET['action'])){
    $_GET['action'] = 'display-touite';
}

$d = new Dispatcher();
$d->run();
?>
</html>

