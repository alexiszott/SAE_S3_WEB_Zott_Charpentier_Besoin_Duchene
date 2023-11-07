<?php

namespace iutnc\touiter\auth;

class Auth
{
    public static function authenticate(string $email, string $passwd2check): bool
    {
        try {

            $db = \iutnc\deefy\db\ConnectionFactory::makeConnection();
            $sql = "select id,passwd from User where email = ? ";
            $pw = null;
            $resultset = $db->prepare($sql);
            $resultset->bindParam(1, $email);
            $resultset->execute();
            while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
                $pw = $row['passwd'];
                $id = $row['id'];
            }
            session_start();
            if (!password_verify($passwd2check, $pw)) {
                $val = false;
            } else {

                $_SESSION['user']=$id;
                $val = true;}
        } catch (AuthException $ex) {
            $ex->getMessage();
        }
        return $val;
    }


    public function register(string $email, string $passEnClair){
        if (strlen($passEnClair) < 10) {
            return false;
        }


        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false;
        }
        // Encodez le mot de passe (vous devriez utiliser une fonction de hachage sécurisée, par exemple, password_hash)
        $hashedPassword = password_hash($passEnClair, PASSWORD_BCRYPT);

        // Insérez le nouvel utilisateur dans la base de données avec le rôle 1
        $query = "INSERT INTO users (email, password, role) VALUES (:email, :password, 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}