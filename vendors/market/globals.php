<?php

Yii::import('application.vendors.*');
require_once('market/db.php');
global $ERROR;
$ERROR = -999;


/**
 * 
 * Function for centralized error reporting
 * 
 * @param type $log A simple string
 * 
 */
function logReport($log) {
    print ("<br> $log");
}


/**
 * Universal initializer
 * 
 * 
 * $return DBHandle Returns a handle to the database if successful, null otherwise.
 * 
 */
function init() {
    global $ERROR;

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    date_default_timezone_set('America/');
    ini_set("memory_limit", -1);
    ini_set('max_execution_time', 300000);

    $dbH = dbOpen();
    return ($dbH);
}


/**
 * 
 * @param type $p
 * @return type
 */
function getURLParameter($p) {
    if (isset($_GET[$p])) {
        return ($_GET[$p]);
    } else {
        return (null);
    }
}

?>