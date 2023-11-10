<?php
declare(strict_types=1);
namespace iutnc\touiter\followable;

use iutnc\touiter\db\ConnexionFactory;

class Tag
{
    private int $tagId;
    private string $tagLibelle;
    private string $tagDescription;

    public function __construct(int $id, string $lib, string $desc){
        $this->tagId = $id;
        $this->tagLibelle = $lib;
        $this->tagDescription = $desc;
    }

    public static function ajouter_tags(?array $tags, int $idTouite) : void {
        if ($tags != null) {
            $pdo = ConnexionFactory::makeConnection();
            // Récupère le nombre de lignes correspondant au tag libelleTag donné ==> 1 s'il existe, 0 sinon
            $sql = "SELECT COUNT(idTag) count, idTag FROM tag WHERE libelleTag = ?";
            $sqlMax = "SELECT MAX(idTAg) maxId FROM tag";
            foreach ($tags as $v) {
                $result = $pdo->prepare($sql);
                $result->bindParam(1, $v);
                $result->execute();
                // Récupération du nombre de lignes correspondant au tag courant à ajouter
                $row =$result->fetch(\PDO::FETCH_ASSOC);
                $count = $row['count'];
                $maxId = $row['idTag'];
                // Transtypage parce que count est récupéré sous forme de String
                if ($count == 0) {
                    $sqlInsertTag = "INSERT INTO tag(libelleTag) VALUES ('$v')";
                    $pdo->exec($sqlInsertTag);
                    $result = $pdo->prepare($sqlMax);
                    $result->execute();
                    $maxId = $result->fetch(\PDO::FETCH_ASSOC)['maxId'];
                }
                // Insertion de la nouvelle ligne dans tag2touite
                $sqlInsertTag2Touite = "INSERT INTO tag2touite VALUES ($maxId, $idTouite)";
                $pdo->exec($sqlInsertTag2Touite);
            }
        }
    }

    public static function makeTagClickable(string $touite) : string {
        $listeChaine = explode(' ', $touite);
        foreach ($listeChaine as $k => $word) {
            if (str_contains($word , '#')) {
                $lien =  "?action=display-tag-touite&tag=" . ltrim($word, '#');
                $word = "<a href=$lien>$word</a>";
                $listeChaine[$k] = $word;
            }
        }
        $touite = implode(' ',$listeChaine);
        return $touite;
    }

    public static function getIdTag(string $nomTag) : int{
        $id = null;
        $pdo = ConnexionFactory::makeConnection();
        $sql="SELECT idTag FROM `tag`
              where libelleTag = ? ";
        $statment = $pdo->prepare($sql);
        $statment->bindParam(1,$nomTag);
        $statment->execute();
        // Recupération de l'id courant
        $row =$statment->fetch(\PDO::FETCH_ASSOC);
        return $row['idTag'];
    }

    public static function followAnyTags(int $idUtil) : bool {
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT * FROM suivretag WHERE idUtil = $idUtil";
        $result = $pdo->prepare($query);
        $result->execute();
        return ($result->rowCount() > 0);
    }

}