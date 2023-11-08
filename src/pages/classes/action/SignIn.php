<?php

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;

<<<<<<< HEAD
=======
use iutnc\touiter\exception\AuthException;


>>>>>>> 91e955c6a89b0d4f89aa87f80417153490bc9da3
class SignIn extends Action
{
           public function execute(): string
    {
        $texte = '';

        if ($this->http_method == 'GET') {

<<<<<<< HEAD
            $texte .= '<form method="post">
                            <table>
                                <tr><td>Email : <input type="email" name="email"><br></td></tr>
                                <tr><td>Mot de passe : <input type="password" name="passwd"><br></td></tr>
                                <th><td><input type = "submit" name = "connect" value = "Connectez-vous"><td></th>
                            </table>
                        </form>' ;
=======
            $texte .= '<form method="post">                        
                        Email : <input type="email" name="email"><br>
                        Mot de passe : <input type="password" name="passwd"><br>
                        <input type = "submit" name = "connect" value = "Connectez-vous">
                         <a href="index.php?action=signup">Créer un compte</a>
                        </form>' ;

>>>>>>> 91e955c6a89b0d4f89aa87f80417153490bc9da3
        } else if ($this->http_method == 'POST') {
            $email = $_POST['email'];
            $mdp=$_POST['passwd'];
            $var = Auth::authenticate($email, $mdp);
            if ($var === true) {
                $texte.="Bienvenue";
            }
<<<<<<< HEAD
=======

>>>>>>> 91e955c6a89b0d4f89aa87f80417153490bc9da3
        }
        return $texte;
    }


}