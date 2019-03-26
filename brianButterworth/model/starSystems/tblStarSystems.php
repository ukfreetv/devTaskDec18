<?php


namespace brianButterworth\model\starSystems;


use brianButterworth\model\src\SqlDatabase;

class tblStarSystems extends SqlDatabase
{


    public function __construct()
    {
        parent::__construct(__CLASS__);
    }


}