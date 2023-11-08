<?php

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;

use iutnc\touiter\exception\AuthException;


class SignIn extends Action
{
           public function execute(): string
    {
        $texte = '<div id="signin">';

        if ($this->http_method == 'GET') {

            $texte .= '<form method="post">
                            <table>
                                <tr><td>Email : </td><td><input type="email" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="password" name="passwd"><br></td></tr>
                                <th><td><input type = "submit" id="confirm" name="connect" value = "Connectez-vous"><br><td></th>
                            </table>
                            <a class="redirection" href="signup.php">Créer un compte</a>
                        </form>' ;
        } else if ($this->http_method == 'POST') {
            $email = $_POST['email'];
            $mdp=$_POST['passwd'];
            $var = Auth::authenticate($email, $mdp);
            if ($var === true) {
                $texte.="Bienvenue";
            }

        }
        $texte .= '</div>';
        return $texte;
    }


}