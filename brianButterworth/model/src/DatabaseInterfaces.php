<?php

namespace brianButterworth\model\src;
abstract class   DatabaseInterfaces
{
    abstract public function select($strFields, $strWhere, $intLimit);

    abstract public function insertItem($strName, $strSerialized);

    abstract public function getSerializedItemByName($strName);
}