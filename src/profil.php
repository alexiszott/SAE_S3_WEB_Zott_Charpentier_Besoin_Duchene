<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset=" UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Touiteur</title>
    <link rel="stylesheet" href="css/touit.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<header>
    <h1>TOUITEUR</h1>
    <div class="menu navigation">
        <a href="index.php">Accueil</a>
    </div>
</header>
<?php
require_once '../vendor/autoload.php';

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\dispatch\Dispatcher;

ConnexionFactory::setConfig('./pages/classes/conf/config.ini');
session_start();
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $id = $user->idUser;
    $_GET['user']=$id;
}

if (!isset($_GET["action"])) {
    $_GET['action'] = 'display-touite';
}

$d = new Dispatcher();
$d->run();

?>
</html>
