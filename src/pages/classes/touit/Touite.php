<?php

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

    public function __construct($i, $d, $m, $fn, $ln, ?string $l = null)
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
                $this->userLike = $result['dlike'];
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

    public static function extraire_tags(string $touite): array|null
    {
        $listeTags = null;
        if (str_contains($touite, '#')) {
            preg_match_all('/#(\w+)/', $touite, $matches);
            if (!empty($matches[1])) {
                $listeTags = $matches[1];
            }
        }
        return $listeTags;
    }

    public function getUserLike()
    {
        $rep = '<form method="post"><input type="hidden" name="touiteId" value="' . $this->id . '">';
        switch ($this->userLike) {
            case -1 :
                $rep .= '<button type="submit" name="like"><i class="bi bi-hand-thumbs-up"></i></button><button type="submit" name="dislike"><i class="bi bi-hand-thumbs-down-fill"></i></button>' . $this->getNbLike() . '</div>';
                //$rep .= '<p><a href="?idT='.$this->id.'&like=y"><i class="bi bi-hand-thumbs-up"></i></a></p><p><a href="?idT='.$this->id.'&like=n"><i class="bi bi-hand-thumbs-down-fill"></i></a></p><p>'.$this->getNbLike() .'</p></div>';
                break;
            case 0 :
                $rep .= '<button type="submit" name="like"><i class="bi bi-hand-thumbs-up"></i></button><button type="submit" name="dislike"><i class="bi bi-hand-thumbs-down"></i></button>' . $this->getNbLike() . '</div>';
                //$rep .= '<p><a href="?idT='.$this->id.'&like=y"><i class="bi bi-hand-thumbs-up"></i></a></p><p><a href="?idT='.$this->id.'&like=n"><i class="bi bi-hand-thumbs-down"></i></a></p><p>'.$this->getNbLike() .'</p></div>';
                break;
            case 1 :
                $rep .= '<button type="submit" name="like"><i class="bi bi-hand-thumbs-up-fill"></i></button><button type="submit" name="dislike"><i class="bi bi-hand-thumbs-down"></i></button>' . $this->getNbLike() . '</div>';
                //$rep .= '<p><a href="?idT='.$this->id.'&like=y"><i class="bi bi-hand-thumbs-up-fill"></i></a></p><p><a href="?idT='.$this->id.'&like=n"><i class="bi bi-hand-thumbs-down"></i></a></p><p>'.$this->getNbLike() .'</p></div>';

                break;
        }
        $rep .= '</form>';
        return $rep;
    }

    public function getNbLike(): string
    {
        $pdo = ConnexionFactory::makeConnection();
        $query = "select SUM(dlike) as dlike from user2like where idTouite= ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $pdo = null;
        if (is_null($result['dlike'])) {
            $res = 0;
        } else {
            $res = $result['dlike'];
        }
        return $res;

    }

    public function setLike()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['user'])) {
                $pdo = ConnexionFactory::makeConnection();
                $query = "select dlike as dlike from user2like where idTouite= ? and idUtil = ?";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $this->id);
                $idUser = unserialize($_SESSION['user']);
                $idU = $idUser->idUser;
                $stmt->bindParam(2, $idU);
                $stmt->execute();
                $query2=null;
                if ($stmt->rowCount() == 0) {
                    if (($_POST['touiteId'] == $this->id) && isset($_POST['like'])) {
                        $query2 = "INSERT INTO user2like VALUES(?,?,1)";
                    }
                    if (($_POST['touiteId'] == $this->id) && isset($_POST['dislike'])) {
                        $query2 = "INSERT INTO user2like VALUES(?,?,-1)";
                    }
                } else {
                    if (($_POST['touiteId'] == $this->id) && isset($_POST['like'])) {
                        if ($this->userLike == 1) {
                            $query2 = "DELETE FROM user2like where idUtil= ? and idTouite = ?";
                        }else {
                            $query2 = "UPDATE user2like SET dlike = 1 where idUtil= ? and idTouite = ?";
                        }
                    }
                    if (($_POST['touiteId'] == $this->id) && isset($_POST['dislike'])) {
                        if ($this->userLike == -1) {
                            $query2 = "DELETE FROM user2like where idUtil= ? and idTouite = ?";
                        } else {
                            $query2 = "UPDATE user2like SET dlike = -1 where idUtil= ? and idTouite = ?";
                        }
                    }
                }
                if(!is_null($query2)){
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->bindParam(1, $idU);
                    $stmt2->bindParam(2, $_POST['touiteId']);
                    $stmt2->execute();
                }
                $pdo = null;
                header('Location: ' . $_SERVER['PHP_SELF']);
            }

        } else {
            header('signin.php');
        }
    }


}