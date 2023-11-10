<?php
declare(strict_types=1);

namespace iutnc\touiter\action;

use iutnc\touiter\followable\User;
use iutnc\touiter\render\TouiteListRenderer;
use iutnc\touiter\touit\TouiteList;

class TagTouiteListDisplay extends Action
{

    public function execute(): string
    {
        $html = "<div class='tag'>";
        if (isset($_GET["tag"])) {
            $tag = $_GET["tag"];
            $touiteList = new TouiteList();
            $touiteList->tagTouiteList($tag);

            $html .= "<h2>Tag : $tag</h2>";
            $t = new TouiteListRenderer($touiteList);
            if (isset($_SESSION['user'])) {
                User::suivreOuNonTag($tag);
                if (User::EtatTag($tag)) {
                    $html .= '<form method="post"> 
                    <button class="buttonNavigation" name="Nesuitpas">Ne plus suivre</button>
                </form>';
                } else {
                    $html .= '<form method="post">
                <button class="buttonNavigation" name="Suit">Suivre</button>
                </form>';
                }

            }
            $html .= "</div>";
            $html .= $t->render();
        }
        return $html;

    }
}