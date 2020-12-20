<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
require('../config.inc.php');
header("Content-Security-Policy: upgrade-insecure-requests");
/*ini_set("memory_limit","1024M");
//echo 'index1.php';
//exit;
*/

function __autoload($class) {
    require LIBS . $class .".php";
}
$db = new Database();

Session::init();
require_once('auth_check.php');
//echo 123;
//exit;

