<?php

namespace iutnc\touiter\db;

use PDO;

class ConnexionFactory{
    private static $config;
    public static function setConfig($file){
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection(){
        $dsn = self::$config['db_driver'] . ':host=' . self::$config['db_host'] . ';dbname=' . self::$config['db_name'];
        $username = self::$config['db_user'];
        $password = self::$config['db_password'];

        try {
            $db = new \PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\PDOException $e) {
            // Handle connection errors
            die('Connection failed: ' . $e->getMessage());
        }
    }
}