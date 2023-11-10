<?php

namespace iutnc\touiter\followable;

use iutnc\touiter\db\ConnexionFactory;

class User
{
    private int $idUser;
    private string $nomUser;
    private string $prenomUser;
    private string $email;
    private string $password;
    private int $permission;

    public function __construct(int $id, string $lastname, string $name, string $mail, string $passwd, int $perm){
        $this->idUser = $id;
        $this->nomUser = $lastname;
        $this->prenomUser = $name;
        $this->email = $mail;
        $this->password = $passwd;
        $this->permission = $perm;
    }

    public function __get(string $at) : mixed{
        if(property_exists($this, $at)){
            return $this->$at;
        } else {
            throw new \Exception ("invalid property : $at");
        }
    }

    public static function EtatTag(string $tag):bool
    {
        $etat = "";
        $idTag = Tag::getIdTag($tag);

        $pdo = ConnexionFactory::makeConnection();
        $sql = "SELECT * FROM suivretag where
             idUtil = ? AND idTag = ?";
        $statment = $pdo->prepare($sql);
        $user = unserialize($_SESSION['user']);
        $idUser = $user->idUser;
        $statment->bindParam(1, $idUser);
        $statment->bindParam(2, $idTag);
        $result = $statment->execute();
        $row = $statment->fetch(\PDO::FETCH_ASSOC);
        return !$row == null;
    }

    public static function suivreOuNonTag(string $tag): void
    {
        $idTag = Tag::getIdTag($tag);
        $pdo = ConnexionFactory::makeConnection();
        $sql = null;
        $user = unserialize($_SESSION['user']);
        $idUser = $user->idUser;
        if (isset($_POST['Nesuitpas'])){
         $sql = "DELETE FROM suivretag WHERE idUtil = ? AND idTag = ? ";

    } if(isset($_POST['Suit'])){
            $sql="INSERT INTO suivretag VALUES (?,?)";
        }
        if(!is_null($sql)){
            $statment = $pdo->prepare($sql);
            $statment->bindParam(1, $idUser);
            $statment->bindParam(2, $idTag);
            $statment->execute();
        }
        $pdo=null;
    }

    public function suitUser(int $id) : bool{
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT * FROM suivreutil WHERE idUtil = ? and idUtilSuivi = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->idUser);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $pdo=null;
        return !($stmt->rowCount() == 0);
    }

    public function suivreOuNonUser(int $id) : void{
        $pdo = ConnexionFactory::makeConnection();
        $query=null;
        if(isset($_POST['suit'])){
            $query = "INSERT INTO suivreutil VALUES (? , ?)";
        }
        if(isset($_POST['suitplu'])){
            $query = "DELETE FROM suivreutil WHERE idUtil = ? and idUtilSuivi = ?";
        }
        if(!is_null($query)){
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $this->idUser);
            $stmt->bindParam(2, $id);
            $stmt->execute();
        }
        $pdo=null;
    }

    public static function followAnyUsers(int $idUtil) : bool
    {
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT * FROM suivreUtil WHERE idUtil = $idUtil";
        $result = $pdo->prepare($query);
        $result->execute();
        return ($result->rowCount() > 0);
    }

    public function calculerScoreTouite() : float {
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT idTouite FROM touite WHERE idUtil = ?";
        $checkTouite = $pdo->prepare($query);
        $checkTouite->bindParam(1, $this->idUser);
        $checkTouite->execute();
        $rep = 0;
        if($checkTouite->rowCount()>0){
            $query2 = "SELECT SUM(dlike) as res FROM user2like WHERE idTouite = ?";
            while ($t = $checkTouite->fetch(\PDO::FETCH_ASSOC)){
                $checkMoyenneTouite = $pdo->prepare($query2);
                $checkMoyenneTouite->bindParam(1, $t['idTouite']);
                $checkMoyenneTouite->execute();
                $resultTouit = $checkMoyenneTouite->fetch(\PDO::FETCH_ASSOC);
                $rep += $resultTouit['res'];
            }
            $rep=$rep/$checkTouite->rowCount();
        }
        $pdo = null;
        return round($rep,2);
    }

    public function listeFollower() : string{
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT suivreutil.idUtil , nomUtil, prenomUtil FROM suivreutil, util WHERE suivreutil.idUtil=util.idUtil and idUtilSuivi = ?";
        $checkFollower = $pdo->prepare($query);
        $checkFollower->bindParam(1, $this->idUser);
        $checkFollower->execute();
        $res = "<h2>Liste des personnes qui vous suivent :</h2>";
        if($checkFollower->rowCount()>0){
            $res .= '<table class="user">';
            while ($follower = $checkFollower->fetch(\PDO::FETCH_ASSOC)){
                $res .= '<tr><td><a href="index.php?user='. $follower['idUtil'] .'">'. $follower['prenomUtil'].' '. $follower['nomUtil'].'</a></td></tr>';
            }
            $res .= '</table>';
        } else {
            $res .= '<p>Personne ne vous suit</p>';
        }
        $pdo=null;
        return $res;
    }

    public static function getRoleUser(int $idUtil) : int {
        return 0;
    }
}