<?php

namespace brianButterworth\model\src;

class SqlDatabase extends SqlDatabaseConnection
{

    public function __construct($strTablename)
    {
        $this->getLastSectionOfCallingClass($strTablename);
        $this->sqlConnection = DatabaseConnectionSingleton::get();
        $this->mysqli = $this->sqlConnection->getMysqli();
    }

    private function getLastSectionOfCallingClass($strTablename)
    {
        $this->strTablename = basename($strTablename);
    }
}