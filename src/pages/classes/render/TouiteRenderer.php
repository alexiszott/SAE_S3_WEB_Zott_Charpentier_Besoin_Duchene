<?php
declare(strict_types=1);

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

        $idUtil = $result["idUtil"];
        //On affiche  le nom, prenom de l'utilisateur
        $html .= "<div class='topTouite'><div class='creator'><i class=\"bi bi-person-circle\"></i><a href=?user=$idUtil> {$this->touite->userFirstName} {$this->touite->userLastName}</a></div>";
        //Si on est connecter alors
        if(isset($_SESSION['user'])){
            //On récupère l'id de l'utilisateur actuellement connecter
            $user = unserialize($_SESSION['user']);
            $id = $user->idUser;
            //On regarde si il correspond à l'id utilisateur associé au touite
            if($result['idUtil']==$id){
                //Si oui alors on affiche le boutton supprimer
                $html .= "
                    <form method=\"post\" action=\"?action=delete-touite\">
                    <button type=\"submit\" class='buttonNavigation' id=\"delButton\" name=\"delete\" value=\"$idTouite\">Suprimer</button>
                    </form>
                    </div>";
            } else {
                //Sinon on ne l'affiche pas
                $html .= "</div>";
            }
        }
        else {
            $html .= "</div>";
        }

        //Permet de selecitoner si le touite est afficher en mode compact ou long
        switch ($selector) {
            case 1 :
                $html .= $this->compact();
                break;
            case 2:
                $html .= $this->long();
                break;
        }
        //On recupère les likes des users pour savoir si il a like le touite
        $html .= $this->touite->getUserLike();
        //On sets le score like / dislike
        $this->touite->setLike();
        //On affiche la date
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