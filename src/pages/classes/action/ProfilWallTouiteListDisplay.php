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

<<<<<<< HEAD
        $id = $_GET['user'];
=======
        $nom = explode('_',$_GET['user']);
        $html = "<div class=\"profileName\"><h2>$nom[0] $nom[1]</h2></div>";
>>>>>>> alexis
        $pdo = ConnexionFactory::makeConnection();
        $sql = "select nomUtil, prenomUtil from util where idUtil = ?";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $id);
        $result->execute();
        $u = $result->fetch(\PDO::FETCH_ASSOC);

        $touitListe = new TouiteList();
        $touitListe->userTouiteList($id);
        $t = new TouiteListRenderer($touitListe);
<<<<<<< HEAD
        $r = $t->render();
        echo "<div class='username'>
                <h2>".$u['prenomUtil']." ".$u['nomUtil']."</h2>
            </div>";
        return $r;
=======
        $html .= $t->render();
        return $html;
>>>>>>> alexis

    }
}