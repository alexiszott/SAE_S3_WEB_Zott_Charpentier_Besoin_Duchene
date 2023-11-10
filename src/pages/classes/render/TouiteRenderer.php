<?php

namespace iutnc\touiter\render;

use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\followable\User;
use iutnc\touiter\touit\Touite;
use iutnc\touiter\followable\Tag;

class TouiteRenderer implements Renderer
{
    private Touite $touite;

    public function __construct(Touite $t)
    {
        $this->touite=$t;
    }

    public function render(?int $selector = null): string
    {
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT idUtil from touite where idTouite = ?";
        $stmt = $pdo->prepare($query);
        $id  = $this->touite->id;
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $pdo = null;
        $html = '<div class="touite">';
        if(isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $id = $user->idUser;
            if($result['idUtil']==$id){
                $html .= "<div class='creator'><i class=\"bi bi-person-circle\"></i><a href='../othersPages/profil.php'> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";
            } else {
                $html .= "<div class='creator'><i class=\"bi bi-person-circle\"></i><a href=?user=".$result['idUtil']."> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";
            }
        } else {
            $html .= "<div class='creator'><i class=\"bi bi-person-circle\"></i><a href=?user=".$result['idUtil']."> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";

        }
        switch ($selector) {
            case 1 :
                $html .= $this->compact();
                break;
            case 2:
                $html .= $this->long();
                break;
        }

        $html .= '<div class="infos"><p>Publié le '.$this->touite->date .'</p>';
        $html .= $this->touite->getUserLike();
        $this->touite->setLike();
        $html .= '</div>';
        return $html;
    }

    private function compact() : string
    {
        if(strlen($this->touite->message ) <= 117){
            $html = '<div class="message"><p>'.Tag::makeTagClickable($this->touite->message).'</p></div>';
        }else{
            $text = substr($this->touite->message, 1, 117) . "...";
            $html = '<p class="message">' . Tag::makeTagClickable($text) . '</p>';
        }

        if(!is_null($this->touite->lienImage)){
            $image = '<p>Contient une image</p>';
            return '<a id="lienTouite" href="./src/pages/main/index.php">'.$html . $image.'</a>';
        }
        $lien = 'index.php?action=display-onetouite&id='.$this->touite->id;

        return $html . "<a href=$lien>Voir plus...</a>";
    }

    private function long()
    {
        $html = '<div class="message"><p class="message">' . Tag::makeTagClickable($this->touite->message) . '</p></div>';
        if(!is_null($this->touite->lienImage)){
            $image = '<br><img href"'.$this->touite->lienImage.'"</img>';
            return $html . $image;
        }
       
        return $html;
    }


}