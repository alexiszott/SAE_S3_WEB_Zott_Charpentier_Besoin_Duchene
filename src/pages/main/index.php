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
    <div class="affiche">
        <?php
        require_once '../../../vendor/autoload.php';
        use iutnc\touiter\followable\User;
        session_start();
        if (isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $prenom = $user->__get("nomUser");
            $nom = $user->__get("prenomUser");
            echo ("$prenom   $nom");

        }else{
            echo ("Veuillez vous connecter");
        }
        ?>
    </div>
    <div class="menu navigation">
        <a href="index.php" class=""><p>Profile</p></a>
        <a href="index.php"><p>Accueil</p></a>
        <a href="../othersPages/writeTouite.php"><p>Ecrire un touite</p></a>
    </div>
    <div class="menu connexion">

        <a href="../othersPages/signin.php" class="connexionButton">Se connecter</a>
        <a href="../othersPages/signup.php" class="connexionButton">S'inscrire</a>
        <a href="?action=disconnect" class="disconnectButton">Se déconnecter</a>
        <a href="../othersPages/signin.php">Se connecter</a>
        <a href="../othersPages/signup.php">S'inscrire</a>


    </div>
    <label>
        <input type="text" placeholder="Rechercher..">
    </label>
</header>
<?php

session_start();

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

