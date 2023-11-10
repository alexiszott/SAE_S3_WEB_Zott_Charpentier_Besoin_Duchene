<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;

class DeleteTouite extends Action
{

    public function execute(): string
    {
        $html = "";
        //On récupère l'ID du touite
        $idTouite = intval($_POST['delete'], 10);
        $pdo = ConnexionFactory::makeConnection();

        //On selectionne l'ID de l'utilisateur du touite qui vas être supprimé
        $sqlIdTouiteUser = "SELECT idUtil FROM touite WHERE idTouite = ?";
        $result = $pdo->prepare($sqlIdTouiteUser);
        $result->bindParam(1, $idTouite);
        $result->execute();
        $idTouiteUser = $result->fetch(\PDO::FETCH_ASSOC);

        $idTU = intval($idTouiteUser['idUtil'],10);
        $userConnectedUnserialized = unserialize($_SESSION["user"]);

        if($idTU === $userConnectedUnserialized->idUser){
            $html .= "<div class='backMenu' id='delConfirm'>
                        <form method='post' action='?action=delete-touite-confirm'>
                        <table id='d'>
                            <tr><th id='textConfirm'>Voulez-vous vraiment supprimer votre touite ?</th></tr></br>
                                    <input type='hidden' name='hiddenInput' id='hiddenInput' value='$idTouite'>
                                    <tr><td><button type='submit' name='confirmButton' class='buttonNavigation' value='0'>Annuler</button></td></br>
                                    <td><button type='submit' name='confirmButton' class='supButton' id='delbuttonConfirm' value='1'>Supprimer</button></tr></td></br>
                            </table>
                        </form>
                    </div>";
        }
        return $html;
    }
}