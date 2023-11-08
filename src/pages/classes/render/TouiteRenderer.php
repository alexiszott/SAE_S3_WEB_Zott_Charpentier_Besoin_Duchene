<?php

namespace iutnc\touiter\render;

use iutnc\touiter\touit\Touite;

class TouiteRenderer implements Renderer
{
    private Touite $touite;

    public function __construct(Touite $t)
    {
        $this->touite=$t;
    }

    public function render(?int $selector = null): string
    {
        $html = '<div class="touite">';
        $html .= '<div class="infos"><p>'.$this->touite->userFirstName.'</p><p>'.$this->touite->userLastName.'</p></div>';

        switch ($selector) {
            case 1 :
                $html .= $this->compact();
                break;
            case 2:
                $msgTouite = $this->long();
                break;
        }
        $html .= '<div class="date"><p> Créé le '.$this->touite->date .'</p></div>';
        $html .= '<div class="interaction"><p>LIKE</p><p>DISLIKE</p></div>';

        return $html;
    }

    private function compact() : string
    {
        if(strlen($this->touite->message ) <= 117){
            $html = '<div class="message"><p>'.$this->touite->message.'</p></div>';
        }else{
            $text = substr($this->touite->message, 1, 117) . "...";
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