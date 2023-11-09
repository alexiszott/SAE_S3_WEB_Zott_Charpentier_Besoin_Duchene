<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class Search extends Action
{

    public function execute(): string
    {
        /**<div class="search">
         * <form method="post" action="?action=search">
         * <input name="search" id="search_bar" type="text" placeholder="Rechercher..">
         * <input type="submit" hidden />
         * </form>
         * </div>
         * **/
         return "";
    }
}