<?php

namespace iutnc\touiter\dispatch;

use iutnc\touiter\Action\Action;
use iutnc\touiter\Action\MainTouiteListDisplay;
use iutnc\touiter\Action\Parameters;
use iutnc\touiter\Action\ProfilTouiteListDisplay;
use iutnc\touiter\Action\ProfilWallTouiteListDisplay;
use iutnc\touiter\Action\SignIn;
use iutnc\touiter\Action\SignUp;
use iutnc\touiter\Action\TagTouiteListDisplay;
use iutnc\touiter\action\TouiteDisplay;
use iutnc\touiter\Action\WriteTouite;

class Dispatcher
{
    protected ?string $action = null;

    public function __construct(){
        $this->action = isset($_GET['action'])? $_GET['action'] : null;
    }

    public function run() : void {
        switch ($this->action){
            case 'display-main-touite':
                $act = new MainTouiteListDisplay();
                $html = $act->execute();
                break;
            case 'parameters':
                $act = new Parameters();
                $html = $act->execute();
                break;
            case 'display-profil-touite':
                $act = new ProfilTouiteListDisplay();
                $html = $act->execute();
                break;
            case 'display-profil-wall-touite':
                $act = new ProfilWallTouiteListDisplay();
                $html = $act->execute();
                break;
            case 'signin':
                $act = new SignIn();
                $html = $act->execute();
                break;
            case 'signup':
                echo "TEST";
                $act = new SignUp();
                $html = $act->execute();
                break;
            case 'display-tag-touite':
                $act = new TagTouiteListDisplay();
                $html = $act->execute();
                break;
            case 'write-touite':
                $act = new WriteTouite();
                $html = $act->execute();
                break;
            case 'display-touite':
                $act = new TouiteDisplay();
                $html = $act->execute();
                break;
        }
        $this->renderPage($html);
    }

    private function renderPage(string $html):void{
        echo <<<FIN
        <body>
                $html
        </body>
    FIN;

    }

}