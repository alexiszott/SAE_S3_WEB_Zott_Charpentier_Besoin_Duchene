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
            // Affichage du tag dont on voit les touites qui le mentionne
            $html .= "<h2>Tag : $tag</h2>";
            $t = new TouiteListRenderer($touiteList);
            if (isset($_SESSION['user'])) {
                // Si l'utilisateur est connecté on lui propose de suivre ou non le tag
                User::suivreOuNonTag($tag);
                if (User::etatTag($tag)) {
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