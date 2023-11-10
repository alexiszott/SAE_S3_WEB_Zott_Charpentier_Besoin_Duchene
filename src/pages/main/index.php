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
    <h1 id="title">TOUITEUR</h1>
        <?php
        require_once '../../../vendor/autoload.php';
        use iutnc\touiter\followable\User;
        use \iutnc\touiter\connect\checkConnexion;
        session_start();
        $c = new checkConnexion();
        echo $c::isConnected();
        ?>
</header>
<div id="writeTouite">
    <form method="post" action="?action=write-touite">
        <table>
            <tr><td><textarea name="touite" maxlength="235" class="text_area" rows="8" cols="55" placeholder="Écrivez votre touite ..."></textarea></tr></td></br>
            <tr><th><button type="submit" class="buttonNavigation" name="envoyer">Touiter</button></th></tr>
        </table>
    </form>
</div>
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

