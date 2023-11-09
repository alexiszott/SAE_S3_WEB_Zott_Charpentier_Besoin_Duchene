<?php

namespace iutnc\touiter\action;

class DeleteTouiteConfirm extends Action
{

    public function execute(): string
    {
        $texte = '';
        if ($this->http_method == 'GET') {
            $texte .= "Salut";
        } else if ($this->http_method == 'POST') {
            $texte .= "Yo";
        }
        return $texte;
    }
}