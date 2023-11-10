<?php

namespace iutnc\touiter\dispatch;


use iutnc\touiter\Action\Action;
use iutnc\touiter\action\DeleteTouite;
use iutnc\touiter\action\DeleteTouiteConfirm;
use iutnc\touiter\action\Disconnect;
use iutnc\touiter\Action\MainTouiteListDisplay;
use iutnc\touiter\Action\ProfilTouiteListDisplay;
use iutnc\touiter\Action\ProfilWallTouiteListDisplay;
use iutnc\touiter\Action\SignIn;
use iutnc\touiter\Action\SignUp;
use iutnc\touiter\Action\TagTouiteListDisplay;
use iutnc\touiter\action\TouiteDisplay;
use iutnc\touiter\action\TouiteListDisplay;
use iutnc\touiter\Action\WriteTouite;
use \iutnc\touiter\page\Pages;

class Dispatcher
{
    protected ?string $action = null;
    public function __construct(){
        $this->action = isset($_GET['action'])? $_GET['action'] : null;
    }

    public function run() : void {

        $p = new Pages();
        $id =null;
        if (isset($_GET['user'])){
            $id = $_GET['user'];
        }

        $html = ' ';
        switch ($this->action){
            case 'display-main-touite':
                $act = new MainTouiteListDisplay();
                $html = $act->execute();
                break;
            case 'display-profil-touite':
                    $html = '<div id="writeTouite">
                    <form method="post" action="?action=write-touite">
                        <table>
                            <tr><td><textarea name="touite" maxlength="235" class="text_area" rows="8" cols="55" placeholder="Écrivez votre touite ..."></textarea></tr></td></br>
                            <tr><th><input type="file" class="buttonNavigation chooseFile" name="image"></th></tr>
                            <tr><th><button type="submit" class="buttonNavigation" name="envoyer">Touiter</button></th></tr>
                        </table>
                    </form>
                </div>';
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
                $act = new TouiteListDisplay();
                $html = '<div id="writeTouite">
                <form method="post" action="?action=write-touite" enctype="multipart/form-data">
                    <table>
                        <tr><th><textarea name="touite" maxlength="235" class="text_area" rows="8" cols="55" placeholder="Écrivez votre touite ..."></textarea></th></tr>
                        <tr><td class="button-container">
                            <label for="imageInput" class="buttonNavigation file-input-label">Ajouter une image</label>
                            <input type="file" name="imageInput" id="imageInput" accept="image/jpeg, image/png">
                            <button type="submit" class="buttonNavigation" name="envoyer">Touiter</button>
                        </td></tr>
                    </table>
                </form>
            </div>';
                $html .= $act->execute();
                if (isset($_GET['user'])) {
                    $act =new ProfilWallTouiteListDisplay();
                    $html= $act->execute();
                }
                $html.=$p->afficherPagination($id);
                break;
            case 'display-onetouite':
                $act = new TouiteDisplay($_GET['id']);
                $html = $act->execute();
                break;
            case 'disconnect':
                $act = new Disconnect();
                $html = $act->execute();
                break;
            case 'delete-touite':
                $act = new DeleteTouite();
                $html = $act->execute();
                break;
            case 'delete-touite-confirm':
                $act = new DeleteTouiteConfirm();
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