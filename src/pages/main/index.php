<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Touiteur</title>
<link rel="stylesheet" href="../../css/touit.css">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<header>
    <h1>TOUITEUR</h1>
        <?php
        require_once '../../../vendor/autoload.php';
        use iutnc\touiter\followable\User;
        use \iutnc\touiter\connect\checkConnexion;
        session_start();
<<<<<<< HEAD
        $c = new checkConnexion();
        echo $c::isConnected();
=======
        //Créer une méthode static pour vérifier la connexion à chaque fois
        if (isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $prenom = $user->__get("nomUser");
            $nom = $user->__get("prenomUser");
            echo ("$prenom   $nom");
            echo "</div>";
            echo "<div class=\"menu connexion\">
        <a href=\"?action=disconnect\" class=\"disconnectButton\" >Se déconnecter</a>
            </div>";
            echo "<div class=\"menu navigation\">
               <a href=\"../othersPages/profil.php\">Profil</a>
                <a href=\"index.php\">Accueil</a>
                <a href=\"../othersPages/writeTouite.php\">Touiter</a>
            </div>";
        }else{
            echo "Vous n'êtes pas connecté.</div>";
            echo "<div class=\"menu connexion\">
                <a href=\"../othersPages/signin.php\" class=\"connexionButton\">Se connecter</a>
                <a href=\"../othersPages/signup.php\" class=\"connexionButton\">S'inscrire</a>
            </div>";
            echo "<div class=\"menu navigation\">
                <a href=\"index.php\">Accueil</a>
                <a href=\"index.php\">Touiter</a>
            </div>";
        }
>>>>>>> c287469981f1078695400e1e36027c9b533c6806
        ?>
    <label>
        <input type="text" placeholder="Rechercher..">
    </label>
</header>
<?php

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

