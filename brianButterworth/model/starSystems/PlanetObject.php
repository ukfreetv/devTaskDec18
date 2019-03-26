<?php

namespace brianButterworth\model\starSystems;
class PlanetObject extends StellarObject
{
    public $collectionOfMoons = [];

    public function addMoon(MoonObject $moonObject)
    {
        $this->collectionOfMoons[$moonObject->intOrbitMeters] = $moonObject;
    }


    public function __toString()
    {
        $strEcho = "";
        ksort($this->collectionOfMoons);
        foreach ($this->collectionOfMoons as $collectionOfMoon) {
            $strEcho .= $collectionOfMoon->strName . ", ";

        }

        return $strEcho;
    }
}