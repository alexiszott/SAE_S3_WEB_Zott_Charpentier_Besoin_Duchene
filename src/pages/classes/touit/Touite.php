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
            $listeChaine = str_word_count($touite, 1, '#');
            function tags($var)
            {
                return (str_contains($var, '#'));
            }
            // On filtre les valeurs pour retenir uniquement les chaînes contenant un #
            $listeTags = array_filter($listeChaine, "tags");
            // Après le filtre on obtien des trous dans le tableau, donc on les supprime
            $listeTags = array_values($listeTags);
            // On veut uniquement les mots sans les #
            foreach ($listeTags as $k => $v) {
                $listeTags[$k] = ltrim($v, '#');
            }
        }
        return $listeTags;
    }


}