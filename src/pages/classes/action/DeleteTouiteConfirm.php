<?php

namespace iutnc\touiter\action;

use iutnc\touiter\db\ConnexionFactory;

class DeleteTouiteConfirm extends Action
{

    public function execute(): string
    {
        if ($this->http_method == 'POST') {
            if($_POST['confirmButton'] == 0){
                header("Location: index.php");
                exit();
            } else if ($_POST['confirmButton'] == 1){
                $pdo = ConnexionFactory::makeConnection();
                $sqlIdTouiteUser = "DELETE touite, notation, user2like, tag2touite
                                    FROM touite
                                    LEFT JOIN notation ON touite.idTouite = notation.idTouite
                                    LEFT JOIN user2like ON touite.idTouite = user2like.idTouite
                                    LEFT JOIN tag2touite ON touite.idTouite = tag2touite.idTouite
                                    WHERE touite.idTouite = ?";
                $result = $pdo->prepare($sqlIdTouiteUser);
                $result->bindParam(1, $_POST['hiddenInput']);
                $result->execute();
                header("Location: index.php");
                exit();
            }
        }
        return ' ';
    }
}