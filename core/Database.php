<?php

namespace Core;

class Database
{

    private static $instance;

    private function __construct()
    {
    }

    private static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className;
        }

        return self::$instance;
    }

    private static function initConnection()
    {
        $db = self::getInstance();
        $db = new \PDO('mysql:host=' . \Config::$host . ';port=' . \Config::$port .';dbname=' . \Config::$dbName, \Config::$dbUsername, \Config::$dbPassword);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public static function getDbConn()
    {
        try {
            $db = self::initConnection();
            return $db;
        } catch (\Exception $ex) {
            echo "I was unable to open a connection to the database. " . $ex->getMessage();
            return null;
        }
    }
}
