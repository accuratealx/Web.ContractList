<?php

$Action = '';
if (isset($_GET['Action'])) {
    $Action = $_GET['Action'];
}

//Выполнить действие
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