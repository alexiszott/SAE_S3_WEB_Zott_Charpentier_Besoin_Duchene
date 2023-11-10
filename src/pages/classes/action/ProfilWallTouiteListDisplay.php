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

        $r= "<div class='username'>
                <h2>" . $u['prenomUtil'] . " " . $u['nomUtil'] . "</h2>";
        if (isset($_SESSION['user'])) {
            if ($_SERVER['PHP_SELF'] != '/SAE_S3_WEB_Zott_Charpentier_Besoin_Duchene/src/profil.php') {
                $selfUser = unserialize($_SESSION['user']);
                $selfUser->suivreOuNonUser($id);
                if ($selfUser->suitUser($id)) {
                    $r.= '<form method="post"> 
                        <button name ="suitplu"> Ne plus suivre</button>
                    </form>';
                } else {
                    $r.= '<form method="post">
                    <button name = "suit"> Suivre</button>
                    </form>';
                }

            }
        }
        $r.= '</div>';
        $pdo=null;
        $r .= $t->render();
        return $r;

    }
}