<?php

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
            $sql = "SELECT COUNT(*) count FROM tag WHERE libelleTag = ?";
            $sqlMaxId = "SELECT MAX(idTag) max FROM tag";
            foreach ($tags as $v) {
                $result = $pdo->prepare($sql);
                $result->bindParam(1, $v);
                $result->execute();
                $count = $result->fetch(\PDO::FETCH_ASSOC)['count'];
                $result = $pdo->prepare($sqlMaxId);
                $result->execute();
                $maxIdTable = $result->fetch(\PDO::FETCH_ASSOC)["max"];
                $maxId = max($maxIdTable, 1);
                // Transtypage parce que count est récupéré sous forme de String
                if ($count == 0) {
                    $sqlInsertTag = "INSERT INTO tag(libelleTag) VALUES ('$v')";
                    $pdo->exec($sqlInsertTag);
                    $sqlInsertTag2Touite = "INSERT INTO tag2touite VALUES ($maxId+1, $idTouite)";
                    $pdo->exec($sqlInsertTag2Touite);
                }
            }
        }
    }

    public static function makeTagClickable(string $touite) : string {
        $listeChaine = explode(' ', $touite);
        foreach ($listeChaine as $k => $word) {
            if (str_contains($word , '#')) {
//                echo "WORD" . $word . "WORD<br>";
                $lien =  "?action=display-tag-touite&tag=" . ltrim($word, '#');
                $word = "<a href=$lien>$word</a>";
//                echo "///" . $word . "///<br>";
                $listeChaine[$k] = $word;
            }
        }
        $touite = implode(' ',$listeChaine);
        return $touite;
    }
}