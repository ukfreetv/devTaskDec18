<?php

namespace brianButterworth\controller;

use brianButterworth\test\CreateOurSolarSystemUsingInjections;

class MyTest extends OldAssert
{
    public static function testStarSystem()
    {
        $starSystem = CreateOurSolarSystemUsingInjections::createIt();
        CreateOurSolarSystemUsingInjections::addDwarfPlanets($starSystem);
        self::assert($starSystem->countPlanets() === 9, "countPlanets()!==9");
    }
}