<?php
declare(strict_types=1);

namespace iutnc\touiter\action;

class Disconnect extends Action
{

    public function execute(): string
    {
       if(isset($_SESSION['user'])){
           $_SESSION['user'] = null;
           header("Location: index.php");
           exit();
       }
       return "Deconnexion";
    }
}