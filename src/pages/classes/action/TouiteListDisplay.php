<?php

namespace iutnc\touiter\action;

use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class TouiteListDisplay extends Action
{
    public function execute(): string
    {
        $touitListe = new TouiteList();
        $touitListe->mainTouiteList();
        $t = new TouiteListRenderer($touitListe);
        $r = $t->render();
        return $r;
    }
}