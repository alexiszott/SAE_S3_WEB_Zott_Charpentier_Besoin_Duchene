<?php

namespace iutnc\touiter\touit;

class TouiteList
{
    private array $touiteList;

    public function __construct($touiteList)
    {
    $this->touiteList=$touiteList;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) return $this->$at;
        throw new \Exception ("$at: invalid property");
    }
}