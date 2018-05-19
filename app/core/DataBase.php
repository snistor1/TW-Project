<?php

class DataBase
{
    private static $db = null;
    private static $user='TW';
    private static $password='TW';
    private static $connection = 'localhost/xe';

    public static function getConnection()
    {
        if(self::$db==null)
        {
            self::$db = oci_connect(self::$user,self::$password,self::$connection);
            return self::$db;
        }
        else
            return self::$db;
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }
}