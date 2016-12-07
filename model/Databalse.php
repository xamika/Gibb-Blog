<?php
/**
 * Database Singleton
 */
class Database extends PDO {
    protected $instance;

    //A cache to hold prepared statements
    protected $cache;

    /**
     * Get instance of the PDO
     * @return PDO
     */
    static function getInstance($dsn=NULL,$dbname=NULL,$dbpass=NULL){
        if(!self::$instance){
            self::$instance = new SQLiteDatabase("blog.sqlite");
        }
        return self::$instance;
    }

    function __construct($dsn,$dbname,$dbpass) {
        parent::__construct($dsn,$dbname,$dbpass);
        $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->cache = array();
    }

    /**
     * If the statement is not cached, cache it and return PDOStatement
     * If the statement is already cached, return the cached statement
     * @return PDOStatement
     */
    function getPreparedStatment($query){
        $hash = md5($query);
        if(!isset($this->cache[$hash])){
            $this->cache[$hash] = $this->prepare($query);
        }
        return $this->cache[$hash];
    }

    function __destruct(){
        $this->cache = NULL;
    }
}