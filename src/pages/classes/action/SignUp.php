<?php

namespace iutnc\touiter\action;

use iutnc\touiter\auth\Auth;
use iutnc\touiter\exception\AuthException;

class SignUp extends Action
{

    function __construct()
    {
        parent::__construct();
    }

    public function execute(): string
    {
        $texte = '<div id="signup">';
        if ($this->http_method == 'GET') {
            $texte .= '<form method="post"> 
                        <table>
                                <tr><td>Nom : </td><td><input type="text" id="nom" name="nom" ><br></td></tr>
                                <tr><td>Prenom : </td><td><input type="text" id="prenom" name="prenom"><br></td></tr>
                                <tr><td>Email : </td><td><input type="email" id="email" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="text" id="passwd" name="passwd"><br></td></tr>
                                <tr><td>Verfication du mot de passe : </td><td><input type="text" id="verifPasswd" name="verifPasswd"><br></td></tr>
                                <th><td><input type = "submit" id="confirm" name = "creer" value = "Créer votre compte"><td></th>
                        </table>
                        <p class="redirection">Vous posséder déjà un compte, <a href="signin.php">se connecter</a>.</p>
                        </form>';
        } else if ($this->http_method == 'POST') {
            $nom =$_POST['nom'];
            $prenom = $_POST['prenom'];
            $mdp = $_POST['passwd'];
            $email = $_POST['email'];
            $mpdVerif = $_POST['verifPasswd'];
            if($mdp===$mpdVerif){
                try{
                    $creer = Auth::register($nom,$prenom,$email,$mdp);
                    if ($creer){
                        $texte.="Votre compte a été créée";
                    }else{
                        $texte.="Une erreur s'est levée";
                    }
                }catch (AuthException $authException){
                    $texte.=$authException->getMessage();
                }
            }
            
        }
        $texte .= '</div>';
        return $texte;
    }
}
