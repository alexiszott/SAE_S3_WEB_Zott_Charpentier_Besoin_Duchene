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

    public static function ajouter_tags(array $tags, int $idTouite) : void {
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
            $maxId = $result->fetch(\PDO::FETCH_ASSOC)["max"];
            if ($count === 0) {
                $sqlInsertTag = "INSERT INTO tag(libelleTag, descriptionTag) VALUES ($v, 'NA')";
                $pdo->exec($sqlInsertTag);
                $sqlInsertTag2Touite = "INSERT INTO tag2touite VALUES ($maxId+1, $idTouite)";
                $pdo->exec($sqlInsertTag2Touite);
            }
        }
    }
}