<?php


namespace brianButterworth\model\src;


abstract class AbstractFactoryMethod
{
    abstract static function create(string $strParameter);

}