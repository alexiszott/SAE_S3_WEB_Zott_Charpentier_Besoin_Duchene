<?php

namespace iutnc\touiter\action;

use iutnc\touiter\followable\User;
use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class TagTouiteListDisplay extends Action
{

    public function execute(): string
    {
        $r="";
        if (isset($_GET["tag"])) {
            $tag = $_GET["tag"];
            $touiteList = new TouiteList();
            $touiteList->tagTouiteList($tag);

            $t = new TouiteListRenderer($touiteList);


            if (isset($_SESSION['user'])) {
                    User::suivreOuNonTag($tag);
                    if (User::EtatTag($tag)) {

                        $r .= '<form method="post"> 
                        <button name ="Nesuitpas"> Ne plus suivre</button>
                    </form>';
                    } else {
                        $r .= '<form method="post">
                    <button name = "Suit"> Suivre</button>
                    </form>';
                    }

                }
                }
            $r .= $t->render();
            echo "<h2>Tag : $tag</h2>";

        return $r;
    }
}