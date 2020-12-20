<?php
session_start();
$session_id = session_id();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header("Content-Security-Policy: upgrade-insecure-requests");
// spl_autoload_register(function($class)
// {
//     require LIBS . $class .".php";
// });
require 'config.inc.php';

function __autoload($class)
{
    require LIBS . $class . ".php";
}
$db = new Database();
