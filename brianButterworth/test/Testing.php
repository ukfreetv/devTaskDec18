<?php

namespace brianButterworth\test;

use brianButterworth\controller\MyTest;

class Testing
{


    public function Switcher($strArgument)
    {
        date_default_timezone_set("Europe/London");
        switch ($strArgument) {
            case "all":


                TestAll::PerformAllTests();
                break;


            case "mocking":
                MyTest::testStarSystem();

                break;

            default:
//                var_dump();
                break;
        }
    }
}