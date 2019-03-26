<?php


namespace brianButterworth\model\src;


use Memcache;

class MemcachedConnection extends DatabaseInterfaces
{
    const LOCALHOST = "127.0.0.1";
    const MEMCACHEDPORT = 11211;
    const SECONDS = 1000;
    public $memcache;

    public function __construct()
    {
        echo PHP_EOL . __CLASS__ . PHP_EOL;

        $this->memcache = new Memcache();
        $this->memcache->addServer(self::LOCALHOST, self::MEMCACHEDPORT);
    }

    public function select($strFields, $strWhere, $intLimit)
    {
        var_dump($strWhere);
        die();
        return $this->memcache->get(__CLASS__ . $strName);
    }

    public function insertItem($strName, $strSerialized)
    {
        $this->memcache->set(__CLASS__ . $strName, $strSerialized, 0, self::SECONDS);
    }

    public function getSerializedItemByName($strName)
    {
        return $this->memcache->get(__CLASS__ . $strName);

    }


}

