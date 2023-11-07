<?php

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;
use iutnc\touiter\exception\AuthException;

class SignIn extends Action
{

    public function execute(): string
    {
        $texte = '';

        if ($this->http_method == 'GET') {

            $texte .= '<form method="post">                        
                        Email : <input type="email" name="email"><br>
                        Mot de passe : <input type="password" name="passwd"><br>
                        <input type = "submit" name = "connect" value = "Connectez-vous">
                        </form>' ;

        } else if ($this->http_method == 'POST') {
            $email = $_POST['email'];
            $mdp=$_POST['passwd'];
            $var = Auth::authenticate($email, $mdp);
            if ($var === true) {
                $texte.="Bienvenue";
            }
            }
            return $texte;
        }



}