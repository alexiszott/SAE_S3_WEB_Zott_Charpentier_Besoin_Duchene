<?php
declare(strict_types=1);

namespace iutnc\touiter\action;

class Disconnect extends Action
{

    public function execute(): string
    {
       if(isset($_SESSION['user'])){
           // On supprime l'utilisateur de la session
           unset($_SESSION['user']);
           // Redirection vers la page principale
           header("Location: index.php");
           exit();
       }
       return "Deconnexion";
    }
}