<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;

class DeleteTouite extends Action
{

    public function execute(): string
    {
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
        var_dump($userConnectedUnserialized->idUser);
        var_dump($idTouiteUser);
        if($idTouiteUser == $userConnectedUnserialized->idUser){
            var_dump($idTouiteUser);
        }
        return ' ';
    }
}