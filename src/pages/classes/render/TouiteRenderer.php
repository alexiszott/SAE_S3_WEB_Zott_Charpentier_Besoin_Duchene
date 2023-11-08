<?php

namespace iutnc\touiter\render;

use iutnc\touiter\followable\User;
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
        $firstName = $this->touite->userFirstName;
        $lastName = $this->touite->userLastName;
        $userUrl = User::getUserUrl($firstName, $lastName);
        $html .= "<div class='infos'><a href=?user=$userUrl> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";

        switch ($selector) {
            case 1 :
                $html .= $this->compact();
                break;
            case 2:
                $html .= $this->long();
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
            $html = '<p class="message">'.$text.'</p>';
        }

        if(!is_null($this->touite->lienImage)){
            $image = '<p>Contient une image</p>';
            return '<a id="lienTouite" href="./src/pages/main/index.php">'.$html . $image.'</a>';
        }
        return '<a id="lienTouite" href="index.php?action=display-onetouite&id='. $this->touite->id .'">'.$html.'</a>';
    }

    private function long()
    {
        $html = '<p class="message">'.$this->touite->message.'</p>';
        if(!is_null($this->touite->lienImage)){
            $image = '<br><img href"'.$this->touite->lienImage.'"</img>';
            return $html . $image;
        }
        return $html;
    }


}