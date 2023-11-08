<?php

namespace iutnc\touiter\action;

use iutnc\touiter\action\Action;
use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class ProfilWallTouiteListDisplay extends Action
{

    public function execute(): string
    {

        $nom = explode('_',$_GET['user']);
        $pdo = ConnexionFactory::makeConnection();
        $sql = "select emailUtil from util where nomUtil = ? AND prenomUtil = ? ";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $nom[1]);
        $result->bindParam(2,$nom[0]);
        $result->execute();
        $u = $result->fetch(\PDO::FETCH_ASSOC);
        $email = $u['emailUtil'];

        $touitListe = new TouiteList();
        $touitListe->userTouiteList($email);
        $t = new TouiteListRenderer($touitListe);
        $r = $t->render();
        echo "<div class='username'>
                <h2>$nom[1] $nom[0]</h2>
            </div>";
        return $r;

    }
}