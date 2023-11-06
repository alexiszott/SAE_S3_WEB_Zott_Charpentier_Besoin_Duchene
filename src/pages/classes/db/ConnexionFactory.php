<?php

namespace iutnc\touiter\db;

class ConnexionFactory{
    private static  $config;
    public static function setConfig($file){
        self::$config = parse_ini_file($file);
    }

    public static function makeConnection(){
        $driver = self::$config['driver'];
        $host = self::$config['host'];
        $database = self::$config['database'];
        $dsn = "$driver:hostname=$host;dbname=$database";
        $username = self::$config['username'];
        $pswd = self::$config['password'];
        return new \PDO($dsn, $username, $pswd);
    }
}