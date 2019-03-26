<?php


namespace brianButterworth\model\starSystems;


interface StellarObjectInterface
{
    public function __construct(string $strName, int $intRadiusMeters, int $intOrbitMeters);

    public function getWeight();

}