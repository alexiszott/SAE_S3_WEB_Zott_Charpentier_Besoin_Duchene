<?php
declare(strict_types=1);

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;

use iutnc\touiter\exception\AuthException;


class SignIn extends Action
{
    public function execute(): string
    {
        $texte = '<div id="signin" class="backMenu">';
        // Envoie du formulaire
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
            $emailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
            // Nettoyage des données si l'email est valide
            if ($emailValid) {
                $email = filter_var($emailValid, FILTER_SANITIZE_EMAIL);
                $mdp = filter_var($mdp, FILTER_SANITIZE_STRING);
                $var = Auth::authenticate($email, $mdp);
                // Si l'authentification a eu lieu
                if ($var === true) {
                    $texte .= "Bienvenue !";
                    header("Location: index.php");
                    exit();
                } else {
                    // On renvoie l'utilisateur vers la page d'inscription s'il n'a pas de compte
                    $texte .= "<p>Cet email n'existe pas, veuillez créer un compte</p><br><a href='signup.php'>Créer un compte</a>";
                }
                $texte .= '</div>';
                return $texte;
            }
        }
        return $texte;
    }
}


