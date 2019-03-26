<?php

namespace brianButterworth\test;

use brianButterworth\model\src\DatabaseConnectionFactory;

class TestAll
{
    public static function PerformAllTests()
    {
        if (true) {
            echo "Write an abstract class or interface that models a SQL database connection" . PHP_EOL;
            $databaseConnectionFactory = DatabaseConnectionFactory::create("normal");
            var_dump($databaseConnectionFactory);


            echo PHP_EOL . PHP_EOL . PHP_EOL;
            echo "    -	You may build a single interface or compose multiple areas of concerns
    -	You can make some assumptions that we’re working with a relational database schema.";
            var_dump($databaseConnectionFactory);
            echo PHP_EOL . PHP_EOL . PHP_EOL;
        }


        die();

        echo "  -	Write a factory to create two different types of database connections
    -	They don’t have to be real database engines. Make some up, but demonstrate how a factory
        deals with differences in concrete implementations";
        foreach ([DatabaseConnectionFactory::create("normal"), DatabaseConnectionFactory::create("MEMCACHED")] as $databaseConnectionFactory
        ) {
            echo PHP_EOL . PHP_EOL . "Using \$databaseConnectionFactory class " . get_class($databaseConnectionFactory) . PHP_EOL . str_repeat("-----", 10) . PHP_EOL;

            if (true) {
                echo "-	Implement a class that models some entity (e.g. cat, car, person, foo or bar etc) that will be persisted to a database created by your factory
    -	Your class should demonstrates dependency injection
    -	If you think dependency model is wrong, model it some other way and tell us why your way is better.";
                echo PHP_EOL . PHP_EOL . PHP_EOL;
                $starSystem = CreateOurSolarSystemUsingInjections::createIt();
                CreateOurSolarSystemUsingInjections::addDwarfPlanets($starSystem);
                echo $starSystem;
                echo PHP_EOL . PHP_EOL . PHP_EOL;
                $databaseConnectionFactory->insertItem($starSystem->myStar->strName, serialize($starSystem));
                unset($starSystem);
            }
            echo PHP_EOL . PHP_EOL . "******   ERASED OBJECTS AND RELOAD FROM CONNECTION" . PHP_EOL;
            $serializedItemByName = $databaseConnectionFactory->getSerializedItemByName("Sol");
            $starSystem = unserialize($serializedItemByName);
            echo $starSystem;
        }
    }
}