<?php

require_once "framework/Psr4AutoloaderClass.php";


date_default_timezone_set("Europe/London");
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
function errorHandler($errno, $errstr, $errfile, $errline)
{
    debug_print_backtrace();
    die("{$errstr} in {$errfile} at line {$errline} [{$errno}] ");
}

set_error_handler("errorHandler", E_ALL);