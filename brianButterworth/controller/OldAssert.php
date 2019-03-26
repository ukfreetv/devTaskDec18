<?php


namespace brianButterworth\controller;


class OldAssert
{


    public static function assert($strSomething, $strMessage)
    {
        if ($strSomething !== true) {
            echo $strMessage;
        }
    }

}