<?php

namespace iutnc\touiter\action;

class Disconnect extends Action
{

    public function execute(): string
    {
       if(isset($_SESSION['user'])){
           $_SESSION['user'] = null;
           $html = "Vous êtes déconnecter";
       } else {
           $html = "Vous déjà déconnecter";
       }
       return $html;
    }
}