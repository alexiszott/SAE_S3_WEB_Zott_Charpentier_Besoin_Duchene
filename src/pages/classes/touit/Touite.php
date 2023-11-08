<?php

namespace iutnc\touiter\touit;

use iutnc\touiter\db\ConnexionFactory;

class Touite
{
    private int $id;
    private string $date;
    private string $message;
    private ?string $lienImage;
    private string $userFirstName;
    private string $userLastName;

    public function __construct($i, $d, $m, $fn, $ln, ?string $l=null)
    {
        $this->id=$i;
        $this->date=$d;
        $this->message=$m;
        $this->lienImage=$l;
        $this->userFirstName=$fn;
        $this->userLastName=$ln;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    public static function extraire_tags(string $touite) : array|null
    {
        $listeTags = null;
        if (str_contains($touite, '#')) {
            preg_match_all('/#(\w+)/', $touite, $matches);
            if (!empty($matches[1])) {
                $listeTags = $matches[1];
            }
        }
        return $listeTags;
    }

    public static function nbTouites() : int {
        $sql = "SELECT COUNT(*) count FROM touite";
        $pdo = ConnexionFactory::makeConnection();
        $nbRows = $pdo->query($sql)->fetch(\PDO::FETCH_ASSOC)["count"];
        $pdo = null;
        return $nbRows;
    }
    public function getNbLike() : string{
        $pdo = ConnexionFactory::makeConnection();
        $query = "select SUM(dlike) as dlike from user2like where idTouite= ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $pdo=null;
        if(is_null($result['dlike'])){
            $res = 0;
        } else{
            $res = $result['dlike'];
        }
        return $res;

    }

    public function setLike(){
        if(isset($_SESSION['user'])){
            // Vérifier que l'utilisateur n'a pas encore like
            $pdo = ConnexionFactory::makeConnection();
            $queryCheck = "SELECT * from user2like where idUtil = ? and idTouite = ?";
            $stmt = $pdo->prepare($queryCheck);
            $stmt->bindParam(1, $_SESSION['user']['id']);
            $stmt->bindParam(2, $this->id);
            $stmt->execute();

            if($stmt->rowCount()===0){

            } else {

            }
        }else{
            header('src/pages/othersPages/signin.php');
        }
    }

    public function likeOrDislike(){

    }


}