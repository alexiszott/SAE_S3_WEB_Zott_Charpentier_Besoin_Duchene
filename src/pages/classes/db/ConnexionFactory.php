<?php

namespace iutnc\touiter\db;

class ConnexionFactory{
    private static $config;
    public static function setConfig($file){
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection(){
<<<<<<< HEAD
        $dsn = self::$config['db_driver'] . ':host=' . self::$config['db_host'] . ';dbname=' . self::$config['db_name'];
        $username = self::$config['db_user'];
        $password = self::$config['db_password'];

        try {
            $db = new \PDO($dsn, $username, $password);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\PDOException $e) {
            // Handle connection errors
            die('Connection failed: ' . $e->getMessage());
        }
=======
        self::setConfig("./src/pages/classes/conf/config.ini");
        $driver = self::$config['driver'];
        $host = self::$config['host'];
        $database = self::$config['database'];
        $dsn = "$driver:hostname=$host;dbname=$database";
        $username = self::$config['username'];
        $pswd = self::$config['password'];
        return new \PDO($dsn, $username, $pswd);
>>>>>>> 25357a74e71c4e3267fd19a1ee4586e02c200f71
    }
}