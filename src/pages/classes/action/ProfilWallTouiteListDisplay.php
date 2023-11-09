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
        $html = "<div class=\"profileName\"><h2>$nom[0] $nom[1]</h2></div>";
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
        $html .= $t->render();
        return $html;

    }
}