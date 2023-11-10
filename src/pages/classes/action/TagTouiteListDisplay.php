<?php

namespace iutnc\touiter\action;

use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class TagTouiteListDisplay extends Action
{

    public function execute(): string
    {
        if (isset($_GET["tag"])) {
            $tag = $_GET["tag"];
            $touiteList = new TouiteList();
            $touiteList->tagTouiteList($tag);

            $t = new TouiteListRenderer($touiteList);
            $r = $t->render();
            echo "<div id='tag'><h2>Tag : $tag</h2></div>";
            return $r;
        }

    }
}