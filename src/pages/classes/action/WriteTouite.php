<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\touit\Touite;
use iutnc\touiter\followable\Tag;
class WriteTouite extends Action
{
    public function execute(): string
    {
        $html = "";
        if ($this->http_method === "GET") {
            $html = <<< FIN
            <form method="post">
                <input type="text" name="touite" placeholder="Écrivez votre touite !">
                <button type="submit" name="envoyer">Envoyer</button>
            </form>
FIN;
        }
        else {
            if (isset($_POST["envoyer"])) {
                // Connexion à la base de données
                $pdo = ConnexionFactory::makeConnection();
                $touite = $_POST["touite"];
                // Ajout des tags inexistants dans la table tag
                $listeTags = Touite::extraire_tags($touite);
                // On récupère l'id de user grâce à la session
                $idUtil = $_SESSION["user"];
                // Insertion du touite dans la table touite
                $sqlInsert = "INSERT INTO touite(idUtil, idImage, texteTouite, datePubli) VALUES ($idUtil, null, $touite, sysdate())";
                $pdo->exec($sqlInsert);
                // On récupère le dernier id de la table touite pour le mettre
                $sqlIdTouite = "SELECT MAX(idTouite) max FROM touite";
                $result = $pdo->prepare($sqlIdTouite);
                $result->execute();
                // On récupère les tags (s'il y en a) dans le touite et on les ajoute aux différentes tables (tag, tag2touite)
                $idTouite = $result->fetch(\PDO::FETCH_ASSOC)["max"] + 1;
                Tag::ajouter_tags($listeTags, $idTouite);
                // Insertion du nouveau touite dans la table notation
                $sqlInsert = "INSERT INTO notation VALUES ($idTouite, $idUtil, 0)";
                $pdo->exec($sqlInsert);
            }
        }
        return $html;
    }
}