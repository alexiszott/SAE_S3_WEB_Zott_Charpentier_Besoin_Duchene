<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\render\TouiteRenderer;
use iutnc\touiter\touit\Touite;

class TouiteDisplay extends Action
{
    private int $touite;
    public function __construct(int $idTouite)
    {
        $this->touite=$idTouite;
    }

    public function execute(): string
    {
        $pdo = ConnexionFactory::makeConnection();
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil from touite, util where touite.idUtil=util.idUtil and idTouite= ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->touite);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(is_null($result['idImage'])){
            $tDisplay = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil']);}
        else{
            $query2 = "select cheminImage from image where idImage = ?";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(1, $result['idImage']);
            $stmt2->execute();
            $result2 = $stmt2->fetch(\PDO::FETCH_ASSOC);
            $tDisplay = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil'], $result2['cheminImage']);
        }
        $pdo=null;
        $tRenderer = new TouiteRenderer($tDisplay);
        return $tRenderer->render(2);
    }
}