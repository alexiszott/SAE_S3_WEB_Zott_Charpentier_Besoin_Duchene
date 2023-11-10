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
<<<<<<< HEAD:src/profil.php
    <div class="menu navigation">
        <a href="index.php">Accueil</a>
    </div>
=======
    <?php
    require_once '../../../vendor/autoload.php';
    use iutnc\touiter\followable\User;
    use \iutnc\touiter\connect\checkConnexion;
    session_start();
    $c = new checkConnexion();
    echo $c::isConnected();
    ?>
>>>>>>> 5c802f0d63c04d1bad6bc236cc3e7c620c18bee0:src/pages/othersPages/profil.php
</header>
<?php
require_once '../vendor/autoload.php';

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\dispatch\Dispatcher;

<<<<<<< HEAD:src/profil.php
ConnexionFactory::setConfig('./pages/classes/conf/config.ini');
session_start();
=======
ConnexionFactory::setConfig('../classes/conf/config.ini');

>>>>>>> 5c802f0d63c04d1bad6bc236cc3e7c620c18bee0:src/pages/othersPages/profil.php
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $id = $user->idUser;
    $_GET['user']=$id;
}

$_GET['action'] = 'display-touite';

$d = new Dispatcher();
$d->run();

?>
</html>
