<?php

namespace iutnc\touiter\touit;

class Touite
{
    private int $id;
    private string $date;
    private string $message;
    private string $lienImage;
    private string $userFirstName;
    private string $userLastName;

    public function __construct($i, $d, $m, $l, $fn, $ln)
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

}