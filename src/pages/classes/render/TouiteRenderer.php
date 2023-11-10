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

        $idTouite = $this->touite->id;
        $idUtil = $result["idUtil"];
        $html .= "<div class='topTouite'><div class='creator'><i class=\"bi bi-person-circle\"></i><a href=?user=$idUtil> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";
        if(isset($_SESSION['user'])){
            $user = unserialize($_SESSION['user']);
            $id = $user->idUser;
            if($result['idUtil']==$id){
                $html .= "
                    <form method=\"post\" action=\"?action=delete-touite\">
                    <button type=\"submit\" class='buttonNavigation' id=\"delButton\" name=\"delete\" value=\"$idTouite\">Suprimer</button>
                    </form>
                    </div>";
            } else {
                $html .= "</div>";
            }
        }
        else {
            $html .= "</div>";
        }

        switch ($selector) {
            case 1 :
                $html .= $this->compact();
                break;
            case 2:
                $html .= $this->long();
                break;
        }
        $html .= $this->touite->getUserLike();
        $this->touite->setLike();
        $html .= '<div class="infos"><p>'.$this->touite->date.'</p></div></div></div>';
        return $html;
        }

    private function compact() : string
    {
        if(strlen($this->touite->message ) <= 117){
            $html = '<div class="message"><p>'.Tag::makeTagClickable($this->touite->message).'</p></div>';
        }else{
            $text = substr($this->touite->message, 1, 117) . "...";
            $html = '<div class="message"><p>' . Tag::makeTagClickable($text) . '</p></div>';
        }

        if(!is_null($this->touite->lienImage)){
            $html .= '</br><p>Contient une image</p>';
        }
        $lien = $_SERVER['PHP_SELF'].'?action=display-onetouite&id='.$this->touite->id;
        return $html . "<div class='bottomTouite'><a href=$lien id='voirplus'>Voir plus...</a>";

    }

    private function long()
    {
        $html = '<div class="message"><p>' . Tag::makeTagClickable($this->touite->message) . '</p></div>';
        if(!is_null($this->touite->lienImage)){
            $image = '<br><img src="/src/'.$this->touite->lienImage.'"</img>';
            return $html . $image;
        }
        $html .= '<div class="bottomTouite">';
        return $html;
    }


}