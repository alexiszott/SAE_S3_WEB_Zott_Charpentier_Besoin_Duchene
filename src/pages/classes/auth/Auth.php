<?php

namespace iutnc\touiter\auth;


use iutnc\touiter\db\ConnexionFactory;
use iutnc\touiter\exception\AuthException;
use iutnc\touiter\followable\User;

class Auth
{

    // Authentification
    public static function authenticate(string $email, string $password): bool {
        ConnexionFactory::setConfig('../classes/conf/config.ini');
        $pdo = ConnexionFactory::makeConnection();
        $sql = "select emailUtil, passwd, role from Util where emailUtil = ? ";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $email);
        $result->execute();
        while ($hash = $result->fetch(\PDO::FETCH_ASSOC)) {
            $pdo = null;
            if (password_verify($password, $hash['passwd'])) {
                self::loadProfile($email);
                return true;
            }
        }
        return false;
    }

    public static function loadProfile( string $email): void {
        session_start();
        $pdo = ConnexionFactory::makeConnection();
        $sql = "select idUtil, nomUtil, prenomUtil, emailUtil, passwd, role from util where emailUtil = ? ";
        $result = $pdo->prepare($sql);
        $result->bindParam(1, $email);
        $result->execute();
        $u = $result->fetch(\PDO::FETCH_ASSOC);
        $profile = new User($u['idUtil'], $u['prenomUtil'], $u['nomUtil'], $u['emailUtil'], $u['passwd'], $u['role']);
        $_SESSION['user'] = serialize($profile);
        $pdo=null;
    }


    //Inscription
    public static function register(string $nomUtil, string $prenomUtil, string $email, string $passEnClair){

        // Vérification du format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AuthException("Format de l'e-mail invalide.");
        }

        //Vérification si l'email existe déjà
        ConnexionFactory::setConfig("../classes/conf/config.ini");
        $pdo = ConnexionFactory::makeConnection();
        $query = "SELECT * FROM util WHERE emailUtil = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            throw new AuthException("L'Email est déjà lié à un compte.");
        }

        // Vérification de la puissance du mot de passe
        if (!(new Auth)->checkPasswordStrength($passEnClair, 8)) {
            throw new AuthException("Le mot de passe doit contenir 8 caractères dont une majuscule, une minuscule, un caractère spécial et un chiffre.");
        }

        // Encodez le mot de passe
        $hashedPassword = password_hash($passEnClair, PASSWORD_BCRYPT);

        // Insérez le nouvel utilisateur dans la base de données avec le rôle 1
        $query = "INSERT INTO util(nomUtil, prenomUtil, emailUtil, passwd, role) VALUES (:nom, :prenom, :email, :password, 10)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom', $nomUtil);
        $stmt->bindParam(':prenom', $prenomUtil);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        return true;
    }

    public function checkPasswordStrength(string $pass, int $minimumLength): bool {
        $length = (strlen($pass) >= $minimumLength); // longueur minimale
        $digit = preg_match("#[\d]#", $pass); // au moins un chiffre
        $special = preg_match("#[\W]#", $pass); // au moins un caractere special
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
        if (!$length || !$digit || !$special || !$lower || !$upper){
            return false;
        }
        return true;
    }

    //Contrôle d'accès

    public static function checkAccessLevel(int $required): void
    {
        $userLevel = $_SESSION['user']['level'];
        if (!$userLevel >= $required) {
            throw new AuthException("droits insuffisants");
        }
    }


}