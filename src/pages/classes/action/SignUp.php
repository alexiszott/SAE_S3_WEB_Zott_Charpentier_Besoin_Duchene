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
        $texte = '<div id="signup" class="backMenu">';
        if ($this->http_method == 'GET') {
            $texte .= '<form method="post"> 
                        <table>
                                <tr><td>Nom : </td><td><input type="text" class="text_area" name="nom" ><br></td></tr>
                                <tr><td>Prenom : </td><td><input type="text" class="text_area" name="prenom"><br></td></tr>
                                <tr><td>Email : </td><td><input type="email" class="text_area" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="text" class="text_area" name="passwd"><br></td></tr>
                                <tr><td>Verfication du mot de passe : </td><td><input type="text" class="text_area" name="verifPasswd"><br></td></tr>
                                <tr><th colspan="2"><input type = "submit" id="confirm" name = "creer" value = "Créer votre compte"></td><tr>
                        </table>
                        <p class="redirection">Vous possédez déjà un compte ? <a href="signin.php">Se connecter</a>.</p>
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
            header("Location: ../main/index.php");
            exit();
        }
        $texte .= '</div>';
        return $texte;
    }
}
