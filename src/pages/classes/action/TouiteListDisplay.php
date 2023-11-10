<?php
declare(strict_types=1);

namespace iutnc\touiter\action;

use iutnc\touiter\followable\Tag;
use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;
use iutnc\touiter\followable\User;

class TouiteListDisplay extends Action
{
    public function execute(): string
    {
        $r = "";
        $touitListe = new TouiteList();
        // Initialise la liste de touites à celle par défaut (tous les touites existant)
        $touitListe->mainTouiteList();
        if (isset($_SESSION['user'])) {
            $selfUser = unserialize($_SESSION['user']);
            if (User::followAnyUsers($selfUser->idUser) || Tag::followAnyTags($selfUser->idUser)) {
                // Si l'utilisateur est connecté est suit au moins un utilisateur ou un tag il aura la liste des touites qui le concerne
                $touitListe->getTouiteListInteressant($selfUser->idUser);
            }
        }
        $t = new TouiteListRenderer($touitListe);
        $r = $t->render();
        return $r;
    }
}