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

    public function __construct($i, $d, $m, $fn, $ln, ?string $l=null)
    {
        $this->id=$i;
        $this->date=$d;
        $this->message=$m;
        $this->lienImage=$l;
        $this->userFirstName=$fn;
        $this->userLastName=$ln;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }

    public static function extraire_tags(string $touite) : array|null
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

    public static function nbTouites() : int {
        $sql = "SELECT COUNT(*) count FROM touite";
        $pdo = ConnexionFactory::makeConnection();
        $nbRows = $pdo->query($sql)->fetch(\PDO::FETCH_ASSOC)["count"];
        $pdo = null;
        return $nbRows;
    }

}