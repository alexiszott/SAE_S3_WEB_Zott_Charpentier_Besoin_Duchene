<?php
declare(strict_types=1);

namespace iutnc\touiter\touit;

use iutnc\touiter\db\ConnexionFactory;

class Touite
{
    private int $id;
    private string $date;
    private string $message;
    private ?string $lienImage;
    private string $userFirstName;
    private string $userLastName;
    private int $userLike;

    public function __construct(int $i, string $d, string $m, string $fn, string $ln, ?string $l = null)
    {
        $this->id = $i;
        $this->date = $d;
        $this->message = $m;
        $this->lienImage = $l;
        $this->userFirstName = $fn;
        $this->userLastName = $ln;

        // Like de l'utilisateur connecté.
        if (isset($_SESSION['user'])) {
            $pdo = ConnexionFactory::makeConnection();
            $query = "select dlike as dlike from user2like where idTouite= ? and idUtil = ?";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $this->id);
            $idUser = unserialize($_SESSION['user']);
            $idU = $idUser->idUser;
            $stmt->bindParam(2, $idU);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $pdo = null;
            if ($stmt->rowCount() == 0) {
                $this->userLike = 0;
            } else {
                $this->userLike = intval($result['dlike']);
            }
        } else {
            $this->userLike = 0;
        }
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    //Fonction qui permet d'extraire les tags d'un touite
    public static function extraire_tags(string $touite): array|null
    {
        //On initialise la liste de tags
        $listeTags = null;
        //Si le touite contient un # alors
        if (str_contains($touite, '#')) {
            //Permet d'identifier les mots avec un #
            preg_match_all('/#(\w+)/', $touite, $matches);
            if (!empty($matches[1])) {
                $listeTags = $matches[1];
            }
        }
        return $listeTags;
    }

    //Methode pour afficher les touites que le user a like / dislike
    public function getUserLike()
    {
        $rep = '<div class="interaction"><form method="post"><input type="hidden" name="touiteId" value="' . $this->id . '">';
        switch ($this->userLike) {
            case -1 :
                $rep .= '<button type="submit" name="like" class="interactButton"><i class="bi bi-hand-thumbs-up"></i></button><button type="submit" name="dislike" class="interactButton"><i class="bi bi-hand-thumbs-down-fill"></i></button>' . $this->getNbLike();
                break;
            case 0 :
                $rep .= '<button type="submit" name="like" class="interactButton"><i class="bi bi-hand-thumbs-up"></i></button><button type="submit" name="dislike" class="interactButton"><i class="bi bi-hand-thumbs-down"></i></button>' . $this->getNbLike();
                break;
            case 1 :
                $rep .= '<button type="submit" name="like" class="interactButton"><i class="bi bi-hand-thumbs-up-fill"></i></button><button type="submit" name="dislike" class="interactButton"><i class="bi bi-hand-thumbs-down"></i></button>' . $this->getNbLike();

                break;
        }
        $rep .= '</form></div>';
        return $rep;
    }

    //Methode pour récuperer le nombres de likes / dislikes d'un touite
    public function getNbLike(): mixed
    {
        $pdo = ConnexionFactory::makeConnection();
        //On recupère la somme des like et des dislikes d'un touite grâce à son id
        $query = "select SUM(dlike) as dlike from user2like where idTouite= ?";
        $stmt = $pdo->prepare($query);
        //On lui associe l'id du touite actuel
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $pdo = null;
        //Si il n'y a pas de like, alors le nombre de like = 0
        //Sinon il est égal au nombre de like + dislike
        if (is_null($result['dlike'])) {
            $res = 0;
        } else {
            $res = intval($result['dlike']);
        }
        return $res;
    }

    //Permet de like et dislike un touite
    public function setLike()
    {
        if (isset($_POST['like']) || isset($_POST['dislike'])) {
            if (isset($_SESSION['user'])) {
                $pdo = ConnexionFactory::makeConnection();
                $query = "select dlike as dlike from user2like where idTouite= ? and idUtil = ?";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $this->id);
                $idUser = unserialize($_SESSION['user']);
                $idU = $idUser->idUser;
                $stmt->bindParam(2, $idU);
                $stmt->execute();
                $query2 = null;
                $touiteId = filter_var($_POST["touiteId"], FILTER_SANITIZE_STRING);
                if ($stmt->rowCount() == 0) {
                    if (($touiteId == $this->id) && isset($_POST['like'])) {
                        $query2 = "INSERT INTO user2like VALUES(?,?,1)";
                    }
                    if (($touiteId == $this->id) && isset($_POST['dislike'])) {
                        $query2 = "INSERT INTO user2like VALUES(?,?,-1)";
                    }
                } else {
                    if (($touiteId == $this->id) && isset($_POST['like'])) {
                        if ($this->userLike == 1) {
                            $query2 = "DELETE FROM user2like where idUtil= ? and idTouite = ?";
                        } else {
                            $query2 = "UPDATE user2like SET dlike = 1 where idUtil= ? and idTouite = ?";
                        }
                    }
                    if (($touiteId == $this->id) && isset($_POST['dislike'])) {
                        if ($this->userLike == -1) {
                            $query2 = "DELETE FROM user2like where idUtil= ? and idTouite = ?";
                        } else {
                            $query2 = "UPDATE user2like SET dlike = -1 where idUtil= ? and idTouite = ?";
                        }
                    }
                }
                if (!is_null($query2)) {
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->bindParam(1, $idU);
                    $stmt2->bindParam(2, $touiteId);
                    $stmt2->execute();
                    var_dump($_POST);
                    if ($_GET['action'] == 'display-onetouite') {
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?action=display-onetouite&id=' . $this->id);
                    } elseif (isset($_GET['user'])) {
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?user=' . $_GET['user']);
                    } else {
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    }
                    die();
                }
                $pdo = null;

            }
        }

    }
}