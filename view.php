<?php 

//Имена страниц
const PAGE_WORK = 'work';
const PAGE_ARCHIVE = 'archive';

//Глобальный объект
$Data['Page'] = 'work';
$Data['Title'] = '';
$Data['Table'] = '';
$Data['DaysToDisaster'] = $Config["Logic"]["DaysToDisaster"];

//Определить тип страницы
$Data['Page'] = GetPageName();

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
}

?>