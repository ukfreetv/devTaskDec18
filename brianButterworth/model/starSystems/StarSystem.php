<?php

namespace brianButterworth\model\starSystems;

use Serializable;

class StarSystem implements Serializable
{
    public $myStar = "";
    public $collectionOfPlanets = [];

    public function __construct(StarObject $myStar)
    {
        $this->myStar = $myStar;
    }

    public function serialize()
    {
        return serialize([$this->myStar, $this->collectionOfPlanets]);
    }

    public function unserialize($data)
    {
        list($this->myStar, $this->collectionOfPlanets) = unserialize($data);
    }

    public function addPlanet(PlanetObject $planetObject)
    {
        $this->collectionOfPlanets[$planetObject->intOrbitMeters] = $planetObject;
        return end($this->collectionOfPlanets);
    }

    public function __toString()
    {
        ksort($this->collectionOfPlanets);
        $strEcho = $this->myStar->strName . PHP_EOL;
        foreach ($this->collectionOfPlanets as $collectionOfPlanet) {
            $strEcho .= $collectionOfPlanet->strName . ": " . $collectionOfPlanet->__toString() . PHP_EOL . PHP_EOL;
        }
        return $strEcho;
    }

    public function __wakeup()
    {
        var_dump($this->myStar->strName);
    }

    public function countPlanets()
    {
        return count($this->collectionOfPlanets);
    }
}