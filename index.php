<?php
use Vtiful\Kernel\Format;

//Пути
define("DIR_ROOT", dirname(__FILE__)."/");
define("DIR_COMPONENTS", DIR_ROOT."components/");
define("DIR_MODAL", DIR_ROOT."modal/");
define("DIR_PAGE", DIR_ROOT."page/");

//Подключить нужное
include DIR_ROOT ."config.inc.php";
include DIR_ROOT . "storage.php";

//Подключиться к хранилищу
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


//Обработчик действий
include('processor.php');

//Отображение страниц
include('view.php');

?>