<?php

namespace iutnc\touiter\connect;

class checkConnexion
{
    public static function isConnected() : string{
        $html = '';
        $html = '<div class="affiche">';
        if (isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $prenom = $user->__get("nomUser");
            $nom = $user->__get("prenomUser");
            $html .= ("$prenom   $nom");
            $html .= "</div>";
            $html .= "<div class=\"menu connexion\">
            <a href=\"?action=disconnect\" class=\"disconnectButton\" >Se déconnecter</a>
            </div>";
            $html .= "<div class=\"menu navigation\">
                <a href=\"profil.php\">Profile</a>
                <a href=\"index.php\">Accueil</a>
                <a href=\"writeTouite.php\">Touiter</a>
            </div>";
        }else{
            $html .= "Vous n'êtes pas connecter</div>";
            $html .= "<div class=\"menu connexion\">
                <a href=\"signin.php\" class=\"connexionButton\">Se connecter</a>
                <a href=\"signup.php\" class=\"connexionButton\">S'inscrire</a>
            </div>";
            $html .= "<div class=\"menu navigation\">
                <a href=\"index.php\">Accueil</a>
                <a href=\"index.php\">Touiter</a>
            </div>";
        }
        return $html;
    }
}