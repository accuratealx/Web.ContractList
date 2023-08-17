<?php

function GetPostValue(string $ValueName, string $DefaultValue = ''): string {
    if (isset($_POST[$ValueName])) {
        return $_POST[$ValueName];
    } else {
        return $DefaultValue;
    }
}


$Action = '';
if (isset($_GET['Action'])) {
    $Action = $_GET['Action'];
}

if ($Action == '') {
    header("location: index.php");
    die;
}



define("DIR_ROOT", dirname(__FILE__)."/");
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


switch ($Action) {
    case "New":
        Command_AddNewContract();
    break;

    case "Edit":
        Command_EditContract();
    break;

    case "Delete":
        Command_DeleteContract();
    break;

    case "ToArchive":
        Command_ToArchive();
    break;
}




function Command_AddNewContract() {
    global $Storage;

    $Title = GetPostValue('Title');
    $SignDate = (new DateTime())->setTimestamp(strtotime(GetPostValue('SignDate')));
    $PreparationDate = (new DateTime())->setTimestamp(strtotime(GetPostValue('PreparationDate')));
    $ContractAmount = GetPostValue('ContractAmount');
    $Comment = GetPostValue('Comment');

    try {
        $Storage->AddContract($Title, $SignDate, $PreparationDate, $ContractAmount, $Comment);
    } catch (Exception $E) {
        echo("Произошла ошибка при добавлении контракта." . PHP_EOL . $E->getMessage());
        die;
    }

    header("location: index.php");
}

function Command_EditContract() {
    global $Storage;
    
    $Title = GetPostValue('Title');
    $SignDate = (new DateTime())->setTimestamp(strtotime(GetPostValue('SignDate')));
    $PreparationDate = (new DateTime())->setTimestamp(strtotime(GetPostValue('PreparationDate')));
    $ContractAmount = GetPostValue('ContractAmount');
    $Comment = GetPostValue('Comment');
    $ID = GetPostValue('ID');

    try {
        $Storage->EditContract($ID, $Title, $SignDate, $PreparationDate, $ContractAmount, $Comment);
    } catch (Exception $E) {
        echo("Произошла ошибка при изменении контракта." . PHP_EOL . $E->getMessage());
        die;
    }

    header("location: index.php");
}

function Command_DeleteContract() {
    global $Storage;

    $ID = GetPostValue('ID');

    try {
        $Storage->DeleteContract($ID);
    } catch (Exception $E) {
        echo("Произошла ошибка при удалении контракта." . PHP_EOL . $E->getMessage());
        die;
    }

    header("location: index.php");
};

function Command_ToArchive() {
    global $Storage;

    $ID = GetPostValue('ID');
    $ActSignDate = (new DateTime())->setTimestamp(strtotime(GetPostValue('ActSignDate')));

    try {
        $Storage->ToArchive($ID, $ActSignDate);
    } catch (Exception $E) {
        echo("Произошла ошибка при перемещении контракта в архив." . PHP_EOL . $E->getMessage());
        die;
    }

    header("location: index.php");
};

?>