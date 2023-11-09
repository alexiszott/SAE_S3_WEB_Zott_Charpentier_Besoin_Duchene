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

        if($idTouiteUser['idUtil'] === unserialize($_SESSION["user"])){
            $html .= '<div class="backMenu" id="delConfirm">
                        <form method="post" action="">
                        <p>Voulez-vous vraiment suprimer votre touite ?</p>
                            <div>
                            <button type="submit" name="annuler" id="dontDelButton" value="0">Annuler</button>
                            <button type="submit" name="supprimer" id="delButton" value="1" >Suprimer</button>
                            </div>
                        </form>
                        </div>';
        }
        return $html;
    }
}