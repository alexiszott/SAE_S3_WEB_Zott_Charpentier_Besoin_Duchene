<?php
declare(strict_types=1);

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
        // Envoie du formulaire
        if ($this->http_method == 'GET') {
            $texte .= '<form method="post"> 
                        <table>
                                <tr><td>Nom : </td><td><input type="text" class="textField" name="nom" ><br></td></tr>
                                <tr><td>Prenom : </td><td><input type="text" class="textField" name="prenom"><br></td></tr>
                                <tr><td>Email : </td><td><input type="email" class="textField" name="email"><br></td></tr>
                                <tr><td>Mot de passe : </td><td><input type="text" class="textField" name="passwd"><br></td></tr>
                                <tr><td>Verfication du mot de passe : </td><td><input type="text" class="textField" name="verifPasswd"><br></td></tr>
                                <tr><th colspan="2"><input type = "submit" class="buttonNavigation" name = "creer" value = "Créer votre compte"></td><tr>
                        </table>
                        <p class="redirection">Vous possédez déjà un compte ? <a href="signin.php">Se connecter</a>.</p>
                        </form>';
        } else if ($this->http_method == 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            // Nettoyage des données si l'email est valide
            if ($email) {
                $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
                $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
                $mdp = filter_var($_POST['passwd'], FILTER_SANITIZE_STRING);

                $mpdVerif = filter_var($_POST['verifPasswd'], FILTER_SANITIZE_STRING);
                if($mdp===$mpdVerif){
                    try{
                        // Création du compte si le mdp et sa vérification sont identiques
                        $creer = Auth::register($nom,$prenom,$email,$mdp);
                        if ($creer){
                            $texte.="Votre compte a été créée";
                            header("Location: index.php");
                            exit();
                        }else{
                            $texte.="Une erreur s'est levée";
                        }
                    }catch (AuthException $authException){
                        $texte.=$authException->getMessage();
                    }
                }
            }
            $texte .= '</div>';
        }
        return $texte;
    }
}
