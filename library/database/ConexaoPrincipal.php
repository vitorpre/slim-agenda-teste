<?php

namespace library\database ;

use Illuminate\Database\Capsule\Manager;

/**
 * Created by PhpStorm.
 * User: vitor
 * Date: 19/07/2018
 * Time: 13:16
 */
class ConexaoPrincipal
{
    /**
     * @var Manager
     */
    private static $db = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getConexao()
    {
        if (self::$db === null) {
            self::$db = self::gerarConexao();
        }

        return self::$db;
    }

    private static function gerarConexao()
    {
        $settings = require("../src/settings.php");

        $capsule = new Manager();
        $capsule->addConnection($settings['settings']['db']);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }




}