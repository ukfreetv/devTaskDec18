<?php

namespace brianButterworth\model\src;

use brianButterworth\model\starSystems\tblStarSystems;

class DatabaseConnectionFactory extends AbstractFactoryMethod
{
    public static function create(string $strParameter)
    {
        switch ($strParameter) {
            case "MEMCACHED":
                $database = new MemcacheDatabase();
                break;
            default:
                $database = new tblStarSystems();
                break;
        }
        return $database;
    }
}
