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
            <form action='?action=disconnect'>
            <a href=\"?action=disconnect\" class='buttonNavigation' >Se déconnecter</a>
            </form>
            </div>";
            $html .= "<div class=\"menu navigation\">

                    <a href=\"profil.php\" class='buttonNavigation'>Profile</a>
                    <a href=\"index.php\" class='buttonNavigation'>Accueil</a>

            </div>";
        }else{
            $html .= "Vous n'êtes pas connecter</div>";
            $html .= "<div class=\"menu connexion\">
            <a href=\"signin.php\" class='buttonNavigation'>Se connecter</a>
            <a href=\"signup.php\" class='buttonNavigation'>S'inscrire</a>
            </div>";
            $html .= "<div class=\"menu navigation\">
                <a href=\"index.php\" class='buttonNavigation'>Accueil</a>
            </div>";
        }
        return $html;
    }
}