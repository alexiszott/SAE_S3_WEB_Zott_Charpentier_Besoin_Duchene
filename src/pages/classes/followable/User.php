<?php

namespace iutnc\touiter\user;

use iutnc\touiter\db\ConnexionFactory;

class User implements canBeFollow
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
    public function getTouite(){
        ConnexionFactory::makeConnection();

        //TODO

    }

    public function getTagTouite(){
        ConnexionFactory::makeConnection();

        //TODO

    }

    public function getFollowerTouite(){
        ConnexionFactory::makeConnection();

        //TODO

    }
    public function sendTouite(){
        ConnexionFactory::makeConnection();

        //TODO

    }

    public function interactTouite(){
        ConnexionFactory::makeConnection();

        //TODO

    }

    public function __get(string $at) : mixed{
        if(property_exists($this, $at)){
            return $this->$at;
        } else {
            throw new Exception ("invalid property : $at");
        }
    }
}