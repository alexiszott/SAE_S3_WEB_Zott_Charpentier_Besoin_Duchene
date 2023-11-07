<?php

namespace iutnc\touiter\action;

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
            $mpdVerif = $_POST['verifPasswd'];
            var_dump($mdp);
            var_dump($mpdVerif);
            var_dump($mdp===$mpdVerif);
            $texte .="Bonjour";
        }
        return $texte;
    }
}
