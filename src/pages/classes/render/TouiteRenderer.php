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

//        $firstName = $this->touite->userFirstName;
//        $lastName = $this->touite->userLastName;
//        $userUrl = User::getUserUrl($firstName, $lastName);
        $idTouite = $this->touite->id;
//        $html .= "<div class='creator'><i class=\"bi bi-person-circle\"></i><a href=?user=$userUrl> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";

            switch ($selector) {
                case 1 :
                    $html .= $this->compact();
                    break;
                case 2:
                    $html .= $this->long();
                    break;
            }
        $html .= '<div class="infos"><p>Publié le '.$this->touite->date .'</p>';
        $html .= '<p><i class="bi bi-hand-thumbs-up"></i></p><p><i class="bi bi-hand-thumbs-down"></i></p></div>';

        //Affiche le bouton supprimer si on est le créateur du touite
        $pdo = ConnexionFactory::makeConnection();

        $sqlIdTouiteUser = "SELECT idUtil FROM touite WHERE idTouite = ?";
        $result = $pdo->prepare($sqlIdTouiteUser);
        $result->bindParam(1, $idTouite);
        $result->execute();
        $row = $result->fetch(\PDO::FETCH_ASSOC);
        
        if(isset($_SESSION["user"])){
            $userConnectedUnserialized = unserialize($_SESSION["user"]);
            if(intval($row['idUtil']) === $userConnectedUnserialized->idUser) {
                $html .= "<div class=\"delete\">
                    <form method=\"post\" action=\"?action=delete-touite\">
                    <button type=\"submit\" class='supButton' id=\"delButton\" name=\"delete\" value=\"$idTouite\">Suprimer</button>
                    </form>
                    </div>";
            }
        }
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
            return '<a id="lienTouite" href="'.$_SERVER['PHP_SELF'].'">'.$html . $image.'</a>';
        }
        $lien = $_SERVER['PHP_SELF'].'?action=display-onetouite&id='.$this->touite->id;
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