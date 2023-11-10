<?php
declare(strict_types=1);

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
                $touite = filter_var($_POST["touite"], FILTER_SANITIZE_STRING);
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
                    $dossierImage = "./uploadImages/";

                    if (!file_exists($dossierImage)) {
                        mkdir($dossierImage, 0777, true);
                    }

                    $cheminImage = $dossierImage . $_FILES['imageInput']['name'];

                    // Copie l'image vers le dossier spécifié
                    $r = copy($_FILES['imageInput']['tmp_name'], $cheminImage);

                    if ($r) {
                        //Ajout de l'img dans la BD
                        $sqlInsertImage = "INSERT INTO image(cheminImage) VALUES (?)";
                        $result = $pdo->prepare($sqlInsertImage);
                        $result->bindParam(1, $cheminImage);
                        $result->execute();

                        //id de l'image (dernier id)
                        $idImage = $pdo->lastInsertId();

                        //Ajout du touite avec l'img
                        $sqlInsert = "INSERT INTO touite(idUtil, texteTouite, idImage) VALUES (?, ?, ?)";
                        $result = $pdo->prepare($sqlInsert);
                        $result->bindParam(1, $idUtil);
                        $result->bindParam(2, $touite);
                        $result->bindParam(3, $idImage);
                        $result->execute();
                    } else {
                        echo "Erreur";
                    }
                } else {
                    //Si le touite n'a pas d'image, on insert dans la BD un touite sans image
                    $sqlInsert = "INSERT INTO touite(idUtil, texteTouite) VALUES (?, ?)";
                    $result = $pdo->prepare($sqlInsert);
                    $result->bindParam(1, $idUtil);
                    $result->bindParam(2, $touite);
                    $result->execute();
                }

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