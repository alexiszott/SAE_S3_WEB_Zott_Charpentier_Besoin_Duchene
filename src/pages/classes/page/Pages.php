<?php
declare(strict_types=1);

namespace iutnc\touiter\page;

use iutnc\touiter\db\ConnexionFactory;

class Pages
{
    public int $currentPage;

    function __construct()
    {
        $this->currentPage = 1;
    }

    public static function nbPages($id = null): int
    {

        $pdo = ConnexionFactory::makeConnection();
        //Cas ou il n'y a pas d'email cela retourne tout les touites
        if ($id === null) {
            $sql = "SELECT CEIL(COUNT(idTouite)/10) as nbPages FROM touite";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $page = $result['nbPages'];

        } else {
            $sql = "SELECT CEIL(COUNT(idTouite)/10) as nbPages FROM touite
                    WHERE idUtil = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $page = $result['nbPages'];

        }
        return $page;
    }

    private function pageSuivante(): int
    {
        if (!empty($_GET['page'])) {
            $this->currentPage = (int)strip_tags($_GET['page']);
        } else {
            $this->currentPage = 1;
        }
        $nBpagesTot = self::nbPages();
        if ($this->currentPage < $nBpagesTot) {
            $this->currentPage = $this->currentPage + 1;
        }
        return $this->currentPage;
    }

    private function pagePrecedente(): int
    {
        if (!empty($_GET['page'])) {
            $this->currentPage = (int)strip_tags($_GET['page']);
        } else {
            $this->currentPage = 1;
        }
        if ($this->currentPage > 1) {
            $this->currentPage -= 1;
        }
        return $this->currentPage;
    }

    public static function afficherPagination($id = null): string
    {
        $p = new Pages();
        $html = '<ul class="pagination" style="display: flex; list-style: none; justify-content: center;">
                    <li class="page-item ' . ($p->currentPage == 1 ? "disabled" : "") . '">
                    <a href="?page=' . $p->pagePrecedente() . ($id ? '&user=' . $id : '') . '" class="page-link">←</a></li>';

        for ($page = 1; $page <= $p->NbPages($id); $page++) {

            $html .= '<li class="page-item ' . ($p->currentPage == $page ? "active" : "") . '">';
            $html .= '<a href="?page=' . $page . ($id ? '&user=' . $id : '') . '" class="page-link">' . $page . '</a></li>';
        }


        $html .= '<li class="page-item ' . ($p->currentPage == $page ? "disabled" : "") . '">';
        $html .= '<a href="?page=' . $p->pageSuivante() . ($id ? '&user=' . $id : '') . '" class="page-link">→</a></li>';

        $html .= '</ul>';

        return $html;
    }

}


