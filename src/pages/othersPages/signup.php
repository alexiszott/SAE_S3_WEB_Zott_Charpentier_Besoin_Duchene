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
    <script src="../../js/touit.js"></script>
    <h1>TOUITEUR</h1>
    <div class="menu navigation">
        <a href="../main/index.php"><p>Accueil</p></a>
    </div>
</header>
<?php
$_GET['action'] = 'signup';

require_once '../../../vendor/autoload.php';

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\dispatch\Dispatcher;

ConnexionFactory::setConfig('../classes/conf/config.ini');

$_GET['action'] = 'signup';

$d = new Dispatcher();
$d->run();
?>
</html>