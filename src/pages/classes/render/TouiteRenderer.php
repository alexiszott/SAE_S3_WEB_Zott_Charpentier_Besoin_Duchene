<?php

namespace iutnc\touiter\render;

use iutnc\touiter\render\Renderer;
use iutnc\touiter\touit\Touite;

class TouiteRenderer implements Renderer
{
    private Touite $touite;

    public function __construct(Touite $t)
    {
        $this->touite=$t;
    }

    public function render(int $selector): string
    {
        $html = '<div id="touite">';
        $head = '<div id="userName">'.$this->touite->userFirstName.' '.$this->touite->userLastName.'</div>';

        switch ($selector) {
            case 1 :
                $msgTouite = $this->compact();
                break;
            case 2:
                $msgTouite = $this->long();
                break;
        }
        $footer = '<p id="date"> Créé le '.$this->touite->date . '</p>';

        $html = $html . $msgTouite . $footer . "</div>";
        return $html;
    }

    private function compact() : string
    {
        if(strlen($this->touite->message ) <= 117){
            $html = '<p id="message">'.$this->touite->message.'</p>';
        }else{
            $text = substr($this->touite->message, 1, 117);
            $html = '<p id="message">'.$text.'</p>';
        }

        if(!is_null($this->touite->lienImage)){
            $image = '<p>Contient une image</p>';
            return $html . $image;
        }
        return $html;
    }

    private function long()
    {
        $html = '<p id="message">'.$this->touite->message.'</p>';
        if(!is_null($this->touite->lienImage)){
            $image = '<br><img href"'.$this->touite->lienImage.'"</img>';
            return $html . $image;
        }
        return $html;
    }


}