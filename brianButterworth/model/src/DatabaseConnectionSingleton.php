<?php

namespace brianButterworth\model\src;


use brianButterworth\config\FeaturesMatrix;
use mysqli;

class DatabaseConnectionSingleton
{
    /*
     *   Implement the system-wide database connection as a singleton pattern
     *
     *   this stops the database server from being overloaded by
     *   connections.  This singleton code routes all SQLi though a single
     *   instance (as long as they use this to connect to the database.
     */
    private static $instance; //The single instance
    private $mysqli;


    /*
     *    Look, a private consutrcutor!
     *
     */
    private function __construct()
    {
        $this->mysqli = new mysqli(FeaturesMatrix::server,
            FeaturesMatrix::user
            , FeaturesMatrix::password, FeaturesMatrix::db);
        $this->mysqli->query("SET NAMES 'UTF8';");
        $this->mysqli->query("SET time_zone = 'Europe/Dublin';");
        $this->mysqli->query("USE " . FeaturesMatrix::db);

        // Error handling
        if ($this->mysqli->connect_error) {
            trigger_error("Connection Error: " . $this->mysqli->connect_error, E_USER_ERROR);
        }
    }

    public static function get(): DatabaseConnectionSingleton
    {
        static $db = null;
        if ($db == null)
            $db = new DatabaseConnectionSingleton();
        return $db;
    }

    public static function getInstance()
    {
        if (!self::$instance) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getMysqli()
    {
        return $this->mysqli;
    }

    // Magic method clone is empty to prevent duplication of connection
    // This due to being a Singleton.
    private function __clone()
    {
    }
}
