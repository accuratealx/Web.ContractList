<?php 

//Имена страниц
const PAGE_WORK = 'work';
const PAGE_ARCHIVE = 'archive';

//Глобальный объект
$Data['Page'] = 'work';
$Data['Title'] = '';
$Data['Table'] = '';
$Data['DaysToDisaster'] = $Config["Logic"]["DaysToDisaster"];
$Data['SystemInfo'] = '';
$Data['Enterprise'] = '';

//Определить тип страницы
$Data['Page'] = GetPageName();

//Сведения о системе
$Data['SystemInfo'] = $Config["SystemInfo"];

//Сведения о предприятии
$Data['Enterprise'] = $Config["Enterprise"];

//Подключить страницу
switch ($Data['Page']) {
    case PAGE_WORK:
        $Data['Title'] = 'Список контрактов';
        $Data['Table'] = $Storage->GetContractList();

        include(DIR_PAGE . 'Page_Work.html');
    break;

    case PAGE_ARCHIVE:
        $Data['Title'] = 'Архив контрактов';
        $Data['Table'] = $Storage->GetArchiveList();

        include(DIR_PAGE . 'Page_Archive.html');
    break;
};

function GetPageName($DefaultPage = PAGE_WORK): string {
    $page = $DefaultPage;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    if (($page !== PAGE_WORK) && ($page !== PAGE_ARCHIVE)) {
        $page = PAGE_WORK;
    }

    return $page;
};

?>