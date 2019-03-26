<?php


namespace brianButterworth\model\src;


class SqlDatabaseConnection extends DatabaseInterfaces
{
    public $sqlConnection;
    public $strTablename = "";


    public $mysqli;

    public function insertItem($strName, $strSerialized)
    {
        $strSerialized = $this->mysqli->real_escape_string($strSerialized);
        $strSQL = "INSERT INTO {$this->strTablename} (strName, strSerialized) VALUES ('{$strName}','{$strSerialized}'); ";
        $this->query($strSQL);
    }

    public function query($strSQL)
    {
        return $this->mysqli->query($strSQL);
    }

    public function getSerializedItemByName($strName)
    {
        $a = $this->select("strSerialized", "strName='$strName'", 1);
        return ($a[0]->strSerialized);
    }

    public function select($strFields = "*", $strWhere = "1", $intLimit = 1)
    {
        $strSQL = "SELECT {$strFields} FROM {$this->strTablename} WHERE {$strWhere} LIMIT 0, $intLimit";
        return $this->getAllRows($strSQL);
    }

    final public function getAllRows($strSQL)
    {
        $arrResult = [];
        $qryOne = $this->query($strSQL);
        if (is_object($qryOne)) {
            while ($objectRow = $qryOne->fetch_object()) {
                $arrResult[] = $objectRow;
            }
            $qryOne->free();
        }
        return $arrResult;
    }

}