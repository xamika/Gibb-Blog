<?php

class Database
{

    private static $database;

    function __construct()
    {
        self::$database = new SQLite3(__DIR__ . "/blog.sqlite");
    }

    function insert($query)
    {
        $ret = self::$database->exec($query);
        if (!$ret) {
            return self::$database->lastErrorMsg();
        } else {
            return "success";
        }
    }

    function execute($query)
    {
        $ret = self::$database->exec($query);
        if (!$ret) {
            return self::$database->lastErrorMsg();
        } else {
            return "success";
        }
    }

    function showMany($query)
    {
        return self::$database->query($query);
    }

    function showOne($query)
    {
        $results = self::$database->query($query);
        return $results->fetchArray();
    }
}