<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;

class DeleteTouite extends Action
{

    public function execute(): string
    {
        $html = "";
        //On récupère l'ID du touite
        $idTouite = intval($_POST['delete'],10);
        $pdo = ConnexionFactory::makeConnection();

        //On selectionne l'ID de l'utilisateur du touite qui vas être supprimé
        $sqlIdTouiteUser = "SELECT idUtil FROM touite WHERE idTouite = ?";
        $result = $pdo->prepare($sqlIdTouiteUser);
        $result->bindParam(1,$idTouite);
        $result->execute();
        $idTouiteUser = $result->fetch(\PDO::FETCH_ASSOC);

        //On récupère l'ID de l'utilisateur qui tente de supprimer  le touite
        $userConnectedSerialized = $_SESSION["user"];
        $userConnectedUnserialized = unserialize($userConnectedSerialized);

        if(intval($idTouiteUser['idUtil'],10) === $userConnectedUnserialized->idUser) {
            if($this->http_method == 'GET'){
                $html .= '<div>
                <form method="post">
                    <button type="submit" name="supprimer" value="0">Annuler</button>
                    <button type="submit" name="supprimer" value="1">Suprimer</button>
                </form>
                </div>';
            } else {
                if($_POST['supprimer'] === 0) {
                    echo "Annuler";
                } else {
                    echo "Supprimer";
                }
            }

        }
        return $html;
    }
}