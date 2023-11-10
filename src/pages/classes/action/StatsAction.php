<?php

namespace iutnc\touiter\action;

use iutnc\touiter\action\Action;

class StatsAction extends Action
{

    public function execute(): string
    {
        $user = unserialize($_SESSION['user']);
        $html = '<div class="backMenu" id="stat">';
        $html .= '<p> La moyenne des scores de vos touites est de : '.$user->calculerScoreTouite() .'</p>';
        $html .= $user->listeFollower();
        $html .= '</div>';
        return $html;
    }
}