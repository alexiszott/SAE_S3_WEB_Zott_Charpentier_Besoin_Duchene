<?php

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;

use iutnc\touiter\exception\AuthException;


class SignIn extends Action
{
           public function execute(): string
    {
        $texte = '<div id="signin" class="backMenu">';

        if ($this->http_method == 'GET') {

            $texte .= '<form method="post">
                            <table>
                                <tr><td>Email : </td><td><input type="email" class="text_area" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="password" class="text_area" name="passwd"><br></td></tr>
                                <tr><th colspan="2"><input type="submit" id="confirm" name="connect" value = "Connectez-vous"></td><tr>
                            </table>
                            <p class="redirection"><a href="signup.php">Créer un compte</a></p>
                        </form>' ;
        } else if ($this->http_method == 'POST') {
            $email = $_POST['email'];
            $mdp=$_POST['passwd'];
            $var = Auth::authenticate($email, $mdp);
            if ($var === true) {
                $texte.="Bienvenue !";
            }
            else {
                $texte .= "<p>Cet email n'existe pas, veuillez créer un compte</p><br><a href='signup.php'>Créer un compte</a>";
            }
        }
        $texte .= '</div>';
        return $texte;
    }


}