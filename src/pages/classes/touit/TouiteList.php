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

    //A modifier rajouter la LIMIT qui bug et le NULL comme chemin d'image
    public function mainTouiteList(){
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil order by datePubli";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if(is_null($result['idImage'])){
            $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil']);}
            else{
                $query2 = "select cheminImage from image where idImage = ?";
                $stmt2 = $pdo->query($query2);
                $stmt2->bindParam(1, $result['datePubli']);
                $stmt2->execute();
                $result2 = $stmt->fetch(\PDO::FETCH_ASSOC);
                $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result2['cheminImage'], $result['prenomUtil'], $result['nomUtil']);}
        }
        $pdo=null;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }
}