<?php

namespace brianButterworth\model\starSystems;


class  StellarObject implements StellarObjectInterface
{

    public $fpDensity = 5514;
    public $intRadiusMeters = 1;
    public $strName = "";
    public $intOrbitMeters = 0;

    public function __construct(string $strName, int $intRadiusMeters, int $intOrbitMeters = 0)
    {
        $this->strName = $strName;
        $this->intRadiusMeters = $intRadiusMeters;
        $this->intOrbitMeters = $intOrbitMeters;
    }


    public function getWeight()
    {
        return 2 * pi() * ($this->intRadiusMeters) * $this->fpDensity;
    }

}