<!DOCTYPE html>
<html lang="fr>
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
        <a href="index.php"><p>Acceuil</p></a>
    </div>
    <div class="menu connexion">
        <a href="index.php"><p>Se connecter</p></a>
        <a href="index.php"><p>S'inscrire</p></a>
    </div>
</header>
<body>
<?php

use iutnc\touiter\db\ConnexionFactory;

ConnexionFactory::setConfig('./src/classes/conf/config.ini');

//TODO

?>
</body>
<footer>
    <div>
        <p>Created by</p>
        <div id="creator">
            <p>Alexis Zott</p>
            <p>Thomas Charpentier</p>
            <p>Eloi Duchene</p>
            <p>Baptiste Besoin</p>
        </div>
    </div>
</footer>
</html>

