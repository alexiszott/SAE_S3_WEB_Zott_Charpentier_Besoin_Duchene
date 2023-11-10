<?php

namespace iutnc\touiter\action;

use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class TouiteListDisplay extends Action
{
    public function execute(): string
    {
        $r = "";
        if (isset($_SESSION['user'])) {
            $touitListe = new TouiteList();
            $selfUser = unserialize($_SESSION['user']);
            $touitListe->getTouiteListInteressant($selfUser->idUser);
            $t = new TouiteListRenderer($touitListe);
            $r = $t->render();
        }
        return $r;
    }
}