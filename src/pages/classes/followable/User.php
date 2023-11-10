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
}