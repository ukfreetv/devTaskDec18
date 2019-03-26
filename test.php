<?php
require_once "commonError.php";

use brianButterworth\test\Testing;


$testing = new Testing();
$testing->Switcher(@$argv[1]);