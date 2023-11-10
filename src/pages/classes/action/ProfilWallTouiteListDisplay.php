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
        $id = $_GET['user'];
        $pdo = ConnexionFactory::makeConnection();
        $sql = "select nomUtil, prenomUtil from util where idUtil = ?";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $id);
        $result->execute();
        $u = $result->fetch(\PDO::FETCH_ASSOC);

        $touitListe = new TouiteList();
        $touitListe->userTouiteList($id);
        $t = new TouiteListRenderer($touitListe);
        $r = $t->render();
        echo "<div class='username'>
                <h2>".$u['prenomUtil']." ".$u['nomUtil']."</h2>
            </div>";
        return $r;

    }
}