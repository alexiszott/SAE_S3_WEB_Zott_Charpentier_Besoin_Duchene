<?php

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
        $touitListe->mainTouiteList();
        if (isset($_SESSION['user'])) {
            $selfUser = unserialize($_SESSION['user']);
            if (User::followAnyUsers($selfUser->idUser) || Tag::followAnyTags($selfUser->idUser)) {
                $touitListe->getTouiteListInteressant($selfUser->idUser);
            }
        }
        $t = new TouiteListRenderer($touitListe);
        $r = $t->render();
        return $r;
    }
}