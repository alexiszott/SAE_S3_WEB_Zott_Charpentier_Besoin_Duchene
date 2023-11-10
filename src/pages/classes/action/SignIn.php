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
                                <tr><td>Email : </td><td><input type="email" class="textField" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="password" class="textField" name="passwd"><br></td></tr>
                                <tr><th colspan="2"><input type="submit" class="buttonNavigation" name="connect" value = "Connectez-vous"></td><tr>
                            </table>
                            <p class="redirection"><a href="signup.php">Créer un compte</a></p>
                        </form>';
        } else if ($this->http_method == 'POST') {
            $email = $_POST['email'];
            $mdp = $_POST['passwd'];
            $var = Auth::authenticate($email, $mdp);
            if ($var === true) {
                $texte .= "Bienvenue !";
                header("Location: index.php");
                exit();
            } else {
                $texte .= "<p>Cet email n'existe pas, veuillez créer un compte</p><br><a href='signup.php'>Créer un compte</a>";
                header("Location: signup.php");
            }
            $texte .= '</div>';
            return $texte;
        }
        return $texte;
    }
}


