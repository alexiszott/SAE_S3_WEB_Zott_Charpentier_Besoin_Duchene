<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <title>Panneau administrateur</title>
    </head>
    <body>
        <?php
        require_once '../vendor/autoload.php';

        use iutnc\touiter\db\ConnexionFactory;

        session_start();
            if (isset($_SESSION['admin'])){}
                ConnexionFactory::setConfig('./pages/classes/conf/config.ini');
                $pdo = ConnexionFactory::makeConnection();
                $sql = "SELECT DISTINCT idUtilSuivi FROM suivreutil GROUP BY idUtilSuivi ORDER BY COUNT(idUtilSuivi) DESC ";
                $statment = $pdo->prepare($sql);
                $statment->execute();

                // Création de la boucle
                $i = 0;
                echo "<h1>Utilisateurs les plus suivis</h1> <br>";
                while ($i < 5 && $row = $statment->fetch(\PDO::FETCH_ASSOC)) {
                    $id = $row['idUtilSuivi'];
                    $sql = "SELECT nomUtil , prenomUtil FROM util where idUtil=?";
                    $statment2 = $pdo->prepare($sql);
                    $statment2->bindParam(1, $id);
                    $statment2->execute();
                    $row2 = $statment2->fetch(\PDO::FETCH_ASSOC);
                    echo $row2["prenomUtil"] . " " . $row2["nomUtil"];
                    echo "<br>";
                    $i++;
            }

   

        ?>

    </body>
</html>