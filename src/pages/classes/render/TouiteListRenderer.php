<?php

namespace iutnc\touiter\render;

use iutnc\touiter\touit\TouiteList;

class TouiteListRenderer implements Renderer
{
    private TouiteList $touiteList;

    public function __construct(TouiteList $t)
    {
        $this->touiteList = $t;
    }

    public function render(): string
    {
        $html = "";
        foreach ($this->touiteList as $value){
            $render = new TouiteRenderer($value);
            $html = $html . $render->render(1);
        }
        return $html;
    }
}