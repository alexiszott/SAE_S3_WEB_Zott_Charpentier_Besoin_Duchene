<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\touit\Touite;
use iutnc\touiter\followable\Tag;
class WriteTouite extends Action
{
    public function execute(): string
    {
        session_start();
        if (isset($_SESSION['user'])) {

            if ($this->http_method === "GET") {
                $html = '<div id="writeTouite" class="backMenu">';
                $html .=
                    '<form method="post">
                <table>
                    <tr><td><textarea name="touite" class="text_area" rows="8" cols="55">Écrivez votre touite !</textarea></tr></td></br>
                    <tr><td><button type="submit" name="envoyer">Envoyer</button></th></td>
                </table>
            </form>';
            } else {
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
                    $idTouite = $result->fetch(\PDO::FETCH_ASSOC)["max"] + 1;
                    $sqlInsert = "INSERT INTO touite(idUtil, texteTouite) VALUES ('$idUtil', '$touite')";
                    $pdo->exec($sqlInsert);
                    Tag::ajouter_tags($listeTags, $idTouite);
                    // Insertion du nouveau touite dans la table notation
                    $sqlInsert = "INSERT INTO notation VALUES ($idTouite, $idUtil, 0)";
                    $pdo->exec($sqlInsert);
                    $html .= '</div>';
                }

            }
        } else {
            header("Location: ../othersPages/signin.php");
            exit();
        }
        return $html;
    }
}