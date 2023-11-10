<?php
declare(strict_types=1);

namespace iutnc\touiter\render;

use iutnc\touiter\touit\TouiteList;

class TouiteListRenderer implements Renderer
{
    private TouiteList $touiteList;

    public function __construct(TouiteList $t)
    {
        $this->touiteList = $t;
    }

    public function render(?int $selector = null): string
    {
        $html = "";
        //On itère sur chaque élément et on utilise la classe touiterenderer pour afficher chacun des touites
        foreach ($this->touiteList->touiteList as $value){
            $render = new TouiteRenderer($value);
            $html = $html . $render->render(1);
        }
        return $html;
    }
}