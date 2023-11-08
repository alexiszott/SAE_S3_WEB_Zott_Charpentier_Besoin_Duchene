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
                            <table>
                                <tr><td>Email : <input type="email" name="email"><br></td></tr>
                                <tr><td>Mot de passe : <input type="password" name="passwd"><br></td></tr>
                                <th><td><input type = "submit" name = "connect" value = "Connectez-vous"><td></th>
                            </table>
                            <a href="index.php?action=signup">Créer un compte</a>
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