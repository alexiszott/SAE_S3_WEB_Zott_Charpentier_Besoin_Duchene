<?php

namespace iutnc\touiter\user;

class Tag implements canBeFollow
{
    private int $tagId;
    private string $tagLibelle;
    private string $tagDescription;

    public function __construct(int $id, string $lib, string $desc){
        $this->tagId = $id;
        $this->tagLibelle = $lib;
        $this->tagDescription = $desc;
    }

    public function getTouite()
    {

        // TODO

    }
}