<?php

namespace iutnc\touiter\action;

class SignUp extends Action
{

    function __construct()
    {
        parent::__construct();
    }


    public function execute(): string
    {
        $texte = '';

        if ($this->http_method == 'GET') {
            $texte .= 'Nom : <input type="text" name="nom" ><br>
                        Prenom : <input type="text" name="prenon"><br>
                        Email : <input type="email" name="email"><br>
                        Mot de passe : <input type="text" name="passwd"><br>
                        Verfication du mot de passe : <input type="text" name="verifPasswd"><br>
                        <input type="button" value="Créer un compte">';

        } else if ($this->http_method == 'POST') {

        }
        return $texte;
    }
}
