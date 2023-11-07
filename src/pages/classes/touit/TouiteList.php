<?php

namespace iutnc\touiter\touit;

use iutnc\touiter\db\ConnexionFactory;

class TouiteList
{
    private array $touiteList;
    private int $nPages;

    public function __construct($touiteList)
    {
    $this->touiteList=$touiteList;
    $this->nPages=1;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    public function mainTouiteList(){
        $this->touiteList = [];
        ConnexionFactory::setConfig("./src/pages/conf/conf.ini");
        $pdo = ConnexionFactory::makeConnection();
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil order by datePubli desc limit 10 offset ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->nPages);
        $stmt->execute();

        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if(is_null($result['idImage'])){
            $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], null, $result['prenomUtil'], $result['nomUtil']);}
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
}