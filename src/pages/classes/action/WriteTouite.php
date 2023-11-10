<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\touit\Touite;
use iutnc\touiter\followable\Tag;
class WriteTouite extends Action
{
    public function execute(): string
    {
        $html = null;
        if(isset($_SESSION['user'])) {
            if (isset($_POST["envoyer"])) {

                // Connexion à la base de données
                $pdo = ConnexionFactory::makeConnection();
                $touite = $_POST["touite"];
                // Ajout des tags inexistants dans la table tag
                $listeTags = Touite::extraire_tags($touite);

                // On récupère l'id de user grâce à la session
                $userConnectedSerialized = $_SESSION["user"];
                $userConnectedUnserialized = unserialize($userConnectedSerialized);
                $idUtil = $userConnectedUnserialized->idUser;

                // On récupère le dernier id de la table touite pour le mettre
                $sqlIdTouite = "SELECT MAX(idTouite) max FROM touite";
                $result = $pdo->prepare($sqlIdTouite);
                $result->execute();

                // On récupère les tags (s'il y en a) dans le touite et on les ajoute aux différentes tables (tag, tag2touite)
                $idTouite = max($result->fetch(\PDO::FETCH_ASSOC)["max"]+1, 1);
                //Si le touite a une image
                if (isset($_FILES["imageInput"]) && $_FILES["imageInput"]["error"] == 0) {

                    $retour = copy($_FILES['imageInput']['tmp_name'], $_FILES['imageInput']['name']);

                    if($retour){
                        $sqlInsertImage = "INSERT INTO image(cheminImage) VALUES (?)";
                        $result = $pdo->prepare($sqlInsertImage);
                        $result->bindParam(1, $_FILES['imageInput']['name']);
                        $result->execute();

                        $sqlIdImage = "SELECT MAX(idImage) max FROM image";
                        $result = $pdo->prepare($sqlIdImage);
                        $result->execute();
                        $idImage = max($result->fetch(\PDO::FETCH_ASSOC)["max"], 1);
                        $sqlInsert = "INSERT INTO touite(idUtil, texteTouite, idImage) VALUES ($idUtil, '$touite',$idImage)";
                    }
                } else {
                    $sqlInsert = "INSERT INTO touite(idUtil, texteTouite) VALUES ($idUtil, '$touite')";
                }

                $pdo->exec($sqlInsert);

                Tag::ajouter_tags($listeTags, $idTouite);

                // Insertion du nouveau touite dans la table notation
                $sqlInsert = "INSERT INTO notation VALUES ($idTouite, $idUtil, 0)";
                $pdo->exec($sqlInsert);
                $html .= '</div>';

                header("Location: index.php");
                exit();
            }
        } else {
                header("Location: signin.php");
                exit();
        }
        return $html;
    }
}