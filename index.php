<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

define("DIR_ROOT", dirname(__FILE__)."/");
// define("DIR_CORE", DIR_ROOT."core/");
// define("DIR_TEMPLATE", DIR_ROOT."template/");

$Page = "work";
if (isset($_GET['page'])) {
    $Page = $_GET['page'];
}

if (($Page !== "work") && ($Page !== "archive")) {
    $Page = "work";
}

include "config.inc.php";
include DIR_ROOT . "storage.php";


global $Storage;

try {
    $Storage = new Storage(
        $Config["DataBase"]["Host"],
        $Config["DataBase"]["Port"],
        $Config["DataBase"]["User"],
        $Config["DataBase"]["Password"],
        $Config["DataBase"]["DBName"]
    );
} catch (Exception $E) {
    echo("Произошла ошибка при подключении к хранилищу." . PHP_EOL . $E->getMessage());
    die;
}


include (DIR_ROOT . "page_" . $Page . ".php");

?>