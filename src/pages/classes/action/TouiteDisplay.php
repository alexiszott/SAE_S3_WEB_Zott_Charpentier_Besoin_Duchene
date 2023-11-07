<?php

namespace iutnc\touiter\action;

class TouiteDisplay extends Action
{

    public function execute(): string
    {
        echo "<div class='touite'>
"
        /**
        * if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            * $html = <<<END
        * <h2>AJOUT D'UNE TRACK</h2><br>
        * <form method="post" action="?action=add-podcasttrack">
        * <label for="titre">Titre du podcast</label>
        * <input type="text" name="titre" id="titre"></br></br>
        * <label for="auteur">Auteur</label>
        * <input type="text" name="auteur" id="auteur"></br></br>
        * <label for="duree">Duree (s)</label>
        * <input type="number" name="duree" id="duree"></br></br>
        * <label for="genre">Genre</label>
        * <input type="text" name="genre" id="genre"></br></br>
        * <label for="date">Date</label>
        * <input type="date" name="date" id="date"></br></br>
        * <input type="submit" value="Ajouter"></br>
        * END;
        * } else {
            * $filterTitre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            * $filterAuteur = filter_var($_POST['auteur'], FILTER_SANITIZE_SPECIAL_CHARS);
            * $filterDuree = filter_var($_POST['duree'], FILTER_SANITIZE_SPECIAL_CHARS);
            * $filterGenre = filter_var($_POST['genre'], FILTER_SANITIZE_SPECIAL_CHARS);
            * $filterDate = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
 *
* $podcast = new PodcastTrack($filterTitre, $filterGenre, $filterDuree, "chemin", $filterAuteur, $filterDate);
 *
* $_SESSION['playlist']->insertTrack($podcast);
 *
* $audio = new AudioListRenderer($_SESSION['playlist']);
            * $html =  $audio->render();
            * $html .= '<a href="?action=add-podcasttrack">Ajouter encore une piste</a>';
        * }
         * return $html;
         * }*/
    }
}