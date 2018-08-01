<?php
/**
 * Created by PhpStorm.
 * User: Kraken11
 * Date: 20/10/15
 * Time: 12:37
 */

namespace helpers;

class DbTool
{
    private $settings;
    private $db;
    private $connection;

    /**
     * @var DbTool
     */
    public static $dbTool ;

    public function __construct()
    {
        $this->settings = require("settings.php");
        $dbConfig = $this->settings['mysql'];
        $this->connection = new \PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $this->db = new \NotORM($this->connection);
    }

    public function getDB()
    {
        return $this->db;
    }

    public function getPDO()
    {
        return $this->connection;
    }

    public static function getPdoInstance()
    {
        if (self::$dbTool == null) {
            self::$dbTool = new DbTool() ;
        }

        return self::$dbTool->getPDO() ;
    }
}
