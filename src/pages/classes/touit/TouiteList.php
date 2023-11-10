<?php
declare(strict_types=1);
namespace iutnc\touiter\touit;

use iutnc\touiter\db\ConnexionFactory;

class TouiteList
{
    private array $touiteList;
    private int $nPages;

    public function __construct()
    {
    $this->touiteList = Array();
    $this->nPages=0;
    }


    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    public function creerTouiteListe(\PDOStatement $statement, \PDO $pdo) : void {
        $statement->execute();
        while ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
            if(is_null($result['idImage'])){
                $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil']);}
            else{
                $query2 = "select cheminImage from image where idImage = ?";
                $stmt2 = $pdo->prepare($query2);
                $stmt2->bindParam(1, $result['datePubli']);
                $stmt2->execute();
                $result2 = $statement->fetch(\PDO::FETCH_ASSOC);
                $this->touiteList[] = new Touite($result['idTouite'],$result['datePubli'], $result['texteTouite'], $result['prenomUtil'], $result['nomUtil'], $result2['cheminImage']);}
        }
        $pdo=null;

    }

    public function mainTouiteList() : void {
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        if (isset($_GET['page'])){
            $this->nPages=($_GET['page'])-1;
        }
        $limit = $this->nPages * 10;
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil 
                  from touite, util 
                  where touite.idUtil=util.idUtil 
                  order by datePubli desc limit 10 offset $limit";
        $stmt = $pdo->query($query);
        $this->creerTouiteListe($stmt, $pdo);
    }

    public function userTouiteList(string $id) : void {
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        if (isset($_GET['page'])){
            $this->nPages=($_GET['page'])-1;
        }
        $limit = $this->nPages * 10;
        $query = "select idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil 
                  from touite, util 
                  where touite.idUtil=util.idUtil 
                    and util.idUtil = ? 
                  order by datePubli desc limit 10 offset $limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $id);
        $this->creerTouiteListe($stmt, $pdo);
    }

    public function tagTouiteList(string $tag) : void {
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        if (isset($_GET['page'])){
            $this->nPages=($_GET['page'])-1;
        }
        $limit = $this->nPages * 10;
        $query = "select tag2touite.idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil
                  from touite, util, tag, tag2touite 
                  where touite.idUtil=util.idUtil 
                  and tag2touite.idTouite=touite.idTouite 
                  and tag2touite.idTag=tag.idTag 
                  and tag.libelleTag = ? 
                  order by datePubli desc limit 10 offset $limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $tag);
        $this->creerTouiteListe($stmt, $pdo);
    }

    public function getTouiteListInteressant(string $idUtil) : void {
        $this->touiteList = [];
        $pdo = ConnexionFactory::makeConnection();
        if (isset($_GET['page'])){
            $this->nPages=($_GET['page'])-1;
        }
        $limit = $this->nPages * 10;
        $sqlIdTouite = "SELECT touite.idTouite, idImage, texteTouite, datePubli, prenomUtil, nomUtil
                        FROM touite, util 
                        WHERE touite.idUtil=util.idUtil 
                        AND touite.idTouite IN 
                        (SELECT touite.idTouite FROM touite, suivreutil
                        WHERE touite.idUtil = suivreutil.idUtilSuivi
                        AND suivreUtil.idUtil = :idUtil
                        UNION 
                        SELECT tag2touite.idTouite FROM tag2touite, suivretag
                        WHERE tag2touite.idTag = suivretag.idTag
                        AND suivreTag.idUtil = :idUtil)
                        ORDER BY datePubli DESC;";
        $stmt = $pdo->prepare($sqlIdTouite);
        $stmt->bindParam(":idUtil", $idUtil);
        $this->creerTouiteListe($stmt, $pdo);
        $pdo = null;
    }

}