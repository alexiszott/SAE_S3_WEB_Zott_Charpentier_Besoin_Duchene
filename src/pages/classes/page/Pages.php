<?php

namespace iutnc\touiter\page;

use iutnc\touiter\db\ConnexionFactory;

class Pages
{
    public int $currentPage;
    function __construct() {
        if(isset($_GET['page']) && !empty($_GET['page'])){

            $this->currentPage = (int) strip_tags($_GET['page']);
        }else{
            $this->currentPage = 1;
        }
    }

    public static function nbPages($email=null) : int {
        $pdo = ConnexionFactory::makeConnection();
        $page = 0;
        //Cas ou il n'y a pas d'email cela retourne tout les touites
        if($email===null){
            $sql = "SELECT CEIL(COUNT(idTouite)/10) as nbPages FROM touite";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $page = $result['nbPages'];

        }else {
            $sql = "SELECT CEIL(COUNT(idTouite)/10) as nbPages FROM touite
                    INNER JOIN Util ON touite.idUtil = Util.idUtil
                    WHERE emailUtil =?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1,$email);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $page = $result['nbPages'];

        }
        return $page;
    }

    function pageSuivante(): int
    {
        $nBpagesTot = self::nbPages();
        if ($this->currentPage<$nBpagesTot){
            $this->currentPage+=1;
        }
        return $this->currentPage;
    }

    function pagePrecedente(): int
    {
        if ($this->currentPage>0){
            $this->currentPage-=1;
        }
        return $this->currentPage;
    }

}


