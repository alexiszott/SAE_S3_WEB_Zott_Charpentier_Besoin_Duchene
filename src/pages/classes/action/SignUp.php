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
        $texte = '';

        if ($this->http_method == 'GET') {

            $texte .= '<form method="post"> Nom : <input type="text" name="nom" ><br>
                        Prenom : <input type="text" name="prenom"><br>
                        Email : <input type="email" name="email"><br>
                        Mot de passe : <input type="text" name="passwd"><br>
                        Verfication du mot de passe : <input type="text" name="verifPasswd"><br>
                        <input type = "submit" name = "creer" value = "Créer votre compte">
                        </form>' ;

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
        return $texte;
    }
}
