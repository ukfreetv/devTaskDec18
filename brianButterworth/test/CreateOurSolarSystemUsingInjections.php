<?php

namespace brianButterworth\test;

use brianButterworth\model\starSystems\DwarfPlanetObject;
use brianButterworth\model\starSystems\MoonObject;
use brianButterworth\model\starSystems\PlanetObject;
use brianButterworth\model\starSystems\StarObject;
use brianButterworth\model\starSystems\StarSystem;

class CreateOurSolarSystemUsingInjections
{
    const AU = 149597870700;

    public static function createIt()
    {
        $starSystem = new StarSystem(new StarObject("Sol", 695510E3, 0));
        $starSystem->addPlanet(new PlanetObject('Mercury', 4879E3, 57.9E9));
        $starSystem->addPlanet(new PlanetObject('Venus', 12104E3, 108.2E9));
        $earth = $starSystem->addPlanet(new PlanetObject('Earth', 12756E3, 149.6E9));
        $mars = $starSystem->addPlanet(new PlanetObject('Mars', 6792E3, 227.9E9));
        $jupiter = $starSystem->addPlanet(new PlanetObject('Jupiter', 142984E3, 778.6E9));
        $saturn = $starSystem->addPlanet(new PlanetObject('Saturn', 120536E3, 1433.5E9));
        $uranus = $starSystem->addPlanet(new PlanetObject('Uranus', 51118E3, 2872.5E9));
        $neptune = $starSystem->addPlanet(new PlanetObject('Neptune', 49528E3, 4495.1E9));

        $earth->addMoon(new MoonObject('Moon', 1737.1e3, 384399E3));
        $mars->addMoon(new MoonObject('Phobos', 11.1e3, 9380E3));
        $mars->addMoon(new MoonObject('Deimos', 6.2e3, 23460E3));
        $jupiter->addMoon(new MoonObject('Io', 1818.1e3, 421800E3));
        $jupiter->addMoon(new MoonObject('Europa', 1560.7e3, 671100E3));
        $jupiter->addMoon(new MoonObject('Ganymede', 2634.1e3, 1070400E3));
        $jupiter->addMoon(new MoonObject('Callisto', 2408.4e3, 1882700E3));
        $jupiter->addMoon(new MoonObject('Amalthea', 83.5e3, 181400E3));
        $jupiter->addMoon(new MoonObject('Himalia', 67e3, 11461000E3));
        $jupiter->addMoon(new MoonObject('Elara', 43e3, 11741000E3));
        $jupiter->addMoon(new MoonObject('Pasiphae', 30e3, 23624000E3));
        $jupiter->addMoon(new MoonObject('Sinope', 19e3, 23939000E3));
        $jupiter->addMoon(new MoonObject('Lysithea', 18e3, 11717000E3));
        $jupiter->addMoon(new MoonObject('Carme', 23e3, 23404000E3));
        $jupiter->addMoon(new MoonObject('Ananke', 14e3, 21276000E3));
        $jupiter->addMoon(new MoonObject('Leda', 10e3, 11165000E3));
        $jupiter->addMoon(new MoonObject('Thebe', 49.3e3, 221900E3));
        $jupiter->addMoon(new MoonObject('Adrastea', 8.2e3, 129000E3));
        $jupiter->addMoon(new MoonObject('Metis', 21.5e3, 128000E3));
        $jupiter->addMoon(new MoonObject('Callirrhoe', 4.3e3, 24103000E3));
        $jupiter->addMoon(new MoonObject('Themisto', 4e3, 7284000E3));
        $jupiter->addMoon(new MoonObject('Megaclite', 2.7e3, 23493000E3));
        $jupiter->addMoon(new MoonObject('Taygete', 2.5e3, 23280000E3));
        $jupiter->addMoon(new MoonObject('Chaldene', 1.9e3, 23100000E3));
        $jupiter->addMoon(new MoonObject('Harpalyke', 2.2e3, 20858000E3));
        $jupiter->addMoon(new MoonObject('Kalyke', 2.6e3, 23483000E3));
        $jupiter->addMoon(new MoonObject('Iocaste', 2.6e3, 21060000E3));
        $jupiter->addMoon(new MoonObject('Erinome', 1.6e3, 23196000E3));
        $jupiter->addMoon(new MoonObject('Isonoe', 1.9e3, 23155000E3));
        $jupiter->addMoon(new MoonObject('Praxidike', 3.4e3, 20908000E3));
        $jupiter->addMoon(new MoonObject('Autonoe', 2e3, 24046000E3));
        $jupiter->addMoon(new MoonObject('Thyone', 2e3, 20939000E3));
        $jupiter->addMoon(new MoonObject('Hermippe', 2e3, 21131000E3));
        $jupiter->addMoon(new MoonObject('Aitne', 1.5e3, 23229000E3));
        $jupiter->addMoon(new MoonObject('Eurydome', 1.5e3, 22865000E3));
        $jupiter->addMoon(new MoonObject('Euanthe', 1.5e3, 20797000E3));
        $jupiter->addMoon(new MoonObject('Euporie', 1e3, 19304000E3));
        $jupiter->addMoon(new MoonObject('Orthosie', 1e3, 20720000E3));
        $jupiter->addMoon(new MoonObject('Sponde', 1e3, 23487000E3));
        $jupiter->addMoon(new MoonObject('Kale', 1e3, 23217000E3));
        $jupiter->addMoon(new MoonObject('Pasithee', 1e3, 23004000E3));
        $jupiter->addMoon(new MoonObject('Hegemone', 1.5e3, 23577000E3));
        $jupiter->addMoon(new MoonObject('Mneme', 1e3, 21035000E3));
        $jupiter->addMoon(new MoonObject('Aoede', 2e3, 23980000E3));
        $jupiter->addMoon(new MoonObject('Thelxinoe', 1e3, 21164000E3));
        $jupiter->addMoon(new MoonObject('Arche', 1.5e3, 23355000E3));
        $jupiter->addMoon(new MoonObject('Kallichore', 1e3, 23288000E3));
        $jupiter->addMoon(new MoonObject('Helike', 2e3, 21069000E3));
        $jupiter->addMoon(new MoonObject('Carpo', 1.5e3, 17058000E3));
        $jupiter->addMoon(new MoonObject('Eukelade', 2e3, 23328000E3));
        $jupiter->addMoon(new MoonObject('Cyllene', 1e3, 23809000E3));
        $jupiter->addMoon(new MoonObject('Kore', 1e3, 24543000E3));
        $jupiter->addMoon(new MoonObject('Herse', 1e3, 22983000E3));
        $jupiter->addMoon(new MoonObject('S/2010 J 1', 1e3, 23314335E3));
        $jupiter->addMoon(new MoonObject('S/2010 J 2', 0.5e3, 20307150E3));
        $jupiter->addMoon(new MoonObject('Dia', 2e3, 12570000E3));
        $jupiter->addMoon(new MoonObject('S/2016 J 1', 3e3, 20595480E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 18', 1e3, 20426000E3));
        $jupiter->addMoon(new MoonObject('S/2011 J 2', 0.5e3, 23329710E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 5', 2e3, 23498000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 15', 1e3, 22630000E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 1', 2e3, 23483978E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 3', 1e3, 20224000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 19', 1e3, 23535000E3));
        $jupiter->addMoon(new MoonObject('Valetudo', 0.5e3, 18928095E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 2', 1e3, 23240957E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 3', 1e3, 20639315E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 4', 1e3, 11494801E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 5', 1e3, 23169389E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 6', 1e3, 22394682E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 7', 1e3, 20571458E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 8', 0.5e3, 23174446E3));
        $jupiter->addMoon(new MoonObject('S/2017 J 9', 1e3, 21429955E3));
        $jupiter->addMoon(new MoonObject('S/2018 J 1', 1e3, 11453004E3));
        $jupiter->addMoon(new MoonObject('S/2011 J 1', 0.5e3, 20155290E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 2', 1e3, 28455000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 4', 1e3, 23933000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 9', 0.5e3, 23388000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 10', 1e3, 23044000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 12', 0.5e3, 17833000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 16', 1e3, 20956000E3));
        $jupiter->addMoon(new MoonObject('S/2003 J 23', 1e3, 23566000E3));
        $saturn->addMoon(new MoonObject('Mimas', 198.2e3, 185540E3));
        $saturn->addMoon(new MoonObject('Enceladus', 252.3e3, 238040E3));
        $saturn->addMoon(new MoonObject('Tethys', 536.3e3, 294670E3));
        $saturn->addMoon(new MoonObject('Dione', 562.5e3, 377420E3));
        $saturn->addMoon(new MoonObject('Rhea', 764.5e3, 527070E3));
        $saturn->addMoon(new MoonObject('Titan', 2575.5e3, 1221870E3));
        $saturn->addMoon(new MoonObject('Hyperion', 138.6e3, 1500880E3));
        $saturn->addMoon(new MoonObject('Iapetus', 734.5e3, 3560840E3));
        $saturn->addMoon(new MoonObject('Phoebe', 106.6e3, 12947780E3));
        $saturn->addMoon(new MoonObject('Janus', 90.4e3, 151460E3));
        $saturn->addMoon(new MoonObject('Epimetheus', 58.3e3, 151410E3));
        $saturn->addMoon(new MoonObject('Helene', 16e3, 377420E3));
        $saturn->addMoon(new MoonObject('Telesto', 12e3, 294710E3));
        $saturn->addMoon(new MoonObject('Calypso', 9.5e3, 294710E3));
        $saturn->addMoon(new MoonObject('Atlas', 15.3e3, 137670E3));
        $saturn->addMoon(new MoonObject('Prometheus', 46.8e3, 139380E3));
        $saturn->addMoon(new MoonObject('Pandora', 40.6e3, 141720E3));
        $saturn->addMoon(new MoonObject('Pan', 12.8e3, 133580E3));
        $saturn->addMoon(new MoonObject('Ymir', 9e3, 23140400E3));
        $saturn->addMoon(new MoonObject('Paaliaq', 11e3, 15200000E3));
        $saturn->addMoon(new MoonObject('Tarvos', 7.5e3, 17983000E3));
        $saturn->addMoon(new MoonObject('Ijiraq', 6e3, 11124000E3));
        $saturn->addMoon(new MoonObject('Suttungr', 3.5e3, 19459000E3));
        $saturn->addMoon(new MoonObject('Kiviuq', 8e3, 11110000E3));
        $saturn->addMoon(new MoonObject('Mundilfari', 3.5e3, 18628000E3));
        $saturn->addMoon(new MoonObject('Albiorix', 16e3, 16182000E3));
        $saturn->addMoon(new MoonObject('Skathi', 4e3, 15540000E3));
        $saturn->addMoon(new MoonObject('Erriapus', 5e3, 17343000E3));
        $saturn->addMoon(new MoonObject('Siarnaq', 20e3, 18015400E3));
        $saturn->addMoon(new MoonObject('Thrymr', 3.5e3, 20314000E3));
        $saturn->addMoon(new MoonObject('Narvi', 3.5e3, 19007000E3));
        $saturn->addMoon(new MoonObject('Methone', 1.6e3, 194440E3));
        $saturn->addMoon(new MoonObject('Pallene', 2e3, 212280E3));
        $saturn->addMoon(new MoonObject('Polydeuces', 1.25e3, 377200E3));
        $saturn->addMoon(new MoonObject('Daphnis', 4e3, 136500E3));
        $saturn->addMoon(new MoonObject('Aegir', 3e3, 20751000E3));
        $saturn->addMoon(new MoonObject('Bebhionn', 3e3, 17119000E3));
        $saturn->addMoon(new MoonObject('Bergelmir', 3e3, 19336000E3));
        $saturn->addMoon(new MoonObject('Bestla', 3.5e3, 20192000E3));
        $saturn->addMoon(new MoonObject('Farbauti', 2.5e3, 20377000E3));
        $saturn->addMoon(new MoonObject('Fenrir', 2e3, 22454000E3));
        $saturn->addMoon(new MoonObject('Fornjot', 3e3, 25146000E3));
        $saturn->addMoon(new MoonObject('Hati', 3e3, 19846000E3));
        $saturn->addMoon(new MoonObject('Hyrrokkin', 4e3, 18437000E3));
        $saturn->addMoon(new MoonObject('Kari', 3.5e3, 22089000E3));
        $saturn->addMoon(new MoonObject('Loge', 3e3, 23058000E3));
        $saturn->addMoon(new MoonObject('Skoll', 3e3, 17665000E3));
        $saturn->addMoon(new MoonObject('Surtur', 3e3, 22704000E3));
        $saturn->addMoon(new MoonObject('Anthe', 1e3, 197700E3));
        $saturn->addMoon(new MoonObject('Jarnsaxa', 3e3, 18811000E3));
        $saturn->addMoon(new MoonObject('Greip', 3e3, 18206000E3));
        $saturn->addMoon(new MoonObject('Tarqeq', 3.5e3, 18009000E3));
        $saturn->addMoon(new MoonObject('Aegaeon', 0.25e3, 167500E3));
        $saturn->addMoon(new MoonObject('S/2004 S 7', 3e3, 20999000E3));
        $saturn->addMoon(new MoonObject('S/2004 S 12', 2.5e3, 19878000E3));
        $saturn->addMoon(new MoonObject('S/2004 S 13', 3e3, 18404000E3));
        $saturn->addMoon(new MoonObject('S/2004 S 17', 2e3, 19447000E3));
        $saturn->addMoon(new MoonObject('S/2006 S 1', 3e3, 18790000E3));
        $saturn->addMoon(new MoonObject('S/2006 S 3', 3e3, 22096000E3));
        $saturn->addMoon(new MoonObject('S/2007 S 2', 3e3, 16725000E3));
        $saturn->addMoon(new MoonObject('S/2007 S 3', 3e3, 18975000E3));
        $saturn->addMoon(new MoonObject('S/2009 S 1', 0.15e3, 117000E3));
        $uranus->addMoon(new MoonObject('Ariel', 578.9e3, 190900E3));
        $uranus->addMoon(new MoonObject('Umbriel', 584.7e3, 266000E3));
        $uranus->addMoon(new MoonObject('Titania', 788.9e3, 436300E3));
        $uranus->addMoon(new MoonObject('Oberon', 761.4e3, 583500E3));
        $uranus->addMoon(new MoonObject('Miranda', 235.8e3, 129900E3));
        $uranus->addMoon(new MoonObject('Cordelia', 20.1e3, 49800E3));
        $uranus->addMoon(new MoonObject('Ophelia', 21.4e3, 53800E3));
        $uranus->addMoon(new MoonObject('Bianca', 25.7e3, 59200E3));
        $uranus->addMoon(new MoonObject('Cressida', 39.8e3, 61800E3));
        $uranus->addMoon(new MoonObject('Desdemona', 32e3, 62700E3));
        $uranus->addMoon(new MoonObject('Juliet', 46.8e3, 64400E3));
        $uranus->addMoon(new MoonObject('Portia', 67.6e3, 66100E3));
        $uranus->addMoon(new MoonObject('Rosalind', 36e3, 69900E3));
        $uranus->addMoon(new MoonObject('Belinda', 40.3e3, 75300E3));
        $uranus->addMoon(new MoonObject('Puck', 81e3, 86000E3));
        $uranus->addMoon(new MoonObject('Caliban', 49e3, 7231100E3));
        $uranus->addMoon(new MoonObject('Sycorax', 75e3, 12179400E3));
        $uranus->addMoon(new MoonObject('Prospero', 25e3, 16256000E3));
        $uranus->addMoon(new MoonObject('Setebos', 24e3, 17418000E3));
        $uranus->addMoon(new MoonObject('Stephano', 10e3, 8004000E3));
        $uranus->addMoon(new MoonObject('Trinculo', 9e3, 8504000E3));
        $uranus->addMoon(new MoonObject('Francisco', 6e3, 4276000E3));
        $uranus->addMoon(new MoonObject('Margaret', 5.5e3, 14345000E3));
        $uranus->addMoon(new MoonObject('Ferdinand', 6e3, 20901000E3));
        $uranus->addMoon(new MoonObject('Perdita', 15e3, 76417E3));
        $uranus->addMoon(new MoonObject('Mab', 6e3, 97736E3));
        $uranus->addMoon(new MoonObject('Cupid', 9e3, 74392E3));
        $neptune->addMoon(new MoonObject('Triton', 1353.4e3, 354800E3));
        $neptune->addMoon(new MoonObject('Nereid', 170e3, 5513820E3));
        $neptune->addMoon(new MoonObject('Naiad', 33e3, 48224E3));
        $neptune->addMoon(new MoonObject('Thalassa', 41e3, 50075E3));
        $neptune->addMoon(new MoonObject('Despina', 75e3, 52526E3));
        $neptune->addMoon(new MoonObject('Galatea', 88e3, 61953E3));
        $neptune->addMoon(new MoonObject('Larissa', 97e3, 73548E3));
        $neptune->addMoon(new MoonObject('Proteus', 210e3, 117647E3));
        $neptune->addMoon(new MoonObject('Halimede', 31e3, 15728000E3));
        $neptune->addMoon(new MoonObject('Psamathe', 20e3, 46695000E3));
        $neptune->addMoon(new MoonObject('Sao', 22e3, 22422000E3));
        $neptune->addMoon(new MoonObject('Laomedeia', 21e3, 23571000E3));
        $neptune->addMoon(new MoonObject('Neso', 30e3, 48387000E3));
        $neptune->addMoon(new MoonObject('Hippocamp', 17.4e3, 105283E3));

        return $starSystem;
    }

    public static function addDwarfPlanets(StarSystem &$starSystem)
    {
        $starSystem->addPlanet(new DwarfPlanetObject("Ceres", 946E3, 2.77 * self::AU));
        $pluto = $starSystem->addPlanet(new DwarfPlanetObject("Pluto", 2380E3, 39.48 * self::AU));
        $haumea = $starSystem->addPlanet(new DwarfPlanetObject("Haumea", 1632E3, 43.13 * self::AU));
        $makemake = $starSystem->addPlanet(new DwarfPlanetObject("Makemake", 1430E3, 45.79 * self::AU));
        $eris = $starSystem->addPlanet(new DwarfPlanetObject("Eris", 2326E3, 67.67 * self::AU));
        $haumea->addMoon(new MoonObject('Hi iaka', 160e3, 49880E3));
        $haumea->addMoon(new MoonObject('Namaka', 85e3, 25657E3));
        $makemake->addMoon(new MoonObject('S/2015 (136472) 1', 87.5e3, 21000E3));
        $eris->addMoon(new MoonObject('Dysnomia', 350e3, 37370E3));
        $pluto->addMoon(new MoonObject('Charon', 606e3, 19591E3));
        $pluto->addMoon(new MoonObject('Nix', 23e3, 48671E3));
        $pluto->addMoon(new MoonObject('Hydra', 30.5e3, 64698E3));
        $pluto->addMoon(new MoonObject('Kerberos', 14e3, 57729E3));
        $pluto->addMoon(new MoonObject('Styx', 10e3, 42393E3));
    }
}