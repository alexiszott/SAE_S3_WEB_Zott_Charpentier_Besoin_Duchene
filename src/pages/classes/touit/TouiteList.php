<?php

namespace iutnc\touiter\touit;

use iutnc\touiter\db\ConnexionFactory;

class TouiteList
{
    private array $touiteList;
    private int $nPages;

    public function __construct()
    {
    $this->touiteList = Array();
    $this->nPages=1;
    }

<<<<<<< HEAD
    //A modifier rajouter la LIMIT qui bug et le NULL comme chemin d'image
    public function mainTouiteList(){
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil order by datePubli";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if(is_null($result['idImage'])){
            $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil']);}
=======
    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    public function creerTouiteListe(\PDOStatement $statement, \PDO $pdo){
        $statement->execute();
        while ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
            if(is_null($result['idImage'])){
                $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], null, $result['prenomUtil'], $result['nomUtil']);}
>>>>>>> 25357a74e71c4e3267fd19a1ee4586e02c200f71
            else{
                $query2 = "select cheminImage from image where idImage = ?";
                $stmt2 = $pdo->query($query2);
                $stmt2->bindParam(1, $result['datePubli']);
                $stmt2->execute();
                $result2 = $statement->fetch(\PDO::FETCH_ASSOC);
                $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result2['cheminImage'], $result['prenomUtil'], $result['nomUtil']);}
        }
        $pdo=null;
    }

<<<<<<< HEAD
    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }
=======
    public function mainTouiteList(){
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil order by datePubli desc limit 10 offset ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->nPages);
        $this->creerTouiteListe($stmt, $pdo);
    }

    public function userTouiteList(string $email){
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil and util.emailUtil = ? order by datePubli desc limit 10 offset ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $this->nPages);
        $this->creerTouiteListe($stmt, $pdo);
    }

    public function tagTouiteList(string $tag){
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util, tag, tag2touite where touite.idUtil=util.idUtil and tag2touite.idTouite=touite.idTouite and tag2touite.idTag=tag.idTag and tag.libelleTag = ? order by datePubli desc limit 10 offset ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $tag);
        $stmt->bindParam(2, $this->nPages);
        $this->creerTouiteListe($stmt, $pdo);
    }

>>>>>>> 25357a74e71c4e3267fd19a1ee4586e02c200f71
}