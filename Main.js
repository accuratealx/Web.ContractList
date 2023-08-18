//Текущий выбранный контракт для редактора
var SelectedContract = Object;

//Сбросить выбранный контракт
function ResetSelectedContract() {
    SelectedContract = null;
}

//Заполнить выбранный контракт из строки таблицы
function SetSelectedContractFromTR(tr) {
    SelectedContract.ID = tr.cells[0].innerHTML;
    SelectedContract.Title = tr.cells[2].innerHTML;
    SelectedContract.SignDate = tr.cells[3].innerHTML;
    SelectedContract.PreparationDate = tr.cells[4].innerHTML;
    SelectedContract.ContractAmount = tr.cells[5].innerHTML;
    SelectedContract.Comment = tr.cells[6].innerHTML;
}

//Поправить видимость кнопок панели управления
function CorrectToolbar(Contract = null) {
    Disable = (Contract == null) ? true : false;
    document.getElementById("ToolBtnEdit").disabled = Disable;
    document.getElementById("ToolBtnDelete").disabled = Disable;
    document.getElementById("ToolBtnArchive").disabled = Disable;
}

//Вернуть текущую дату
function GetCurrentDate() {
    return new Date().toISOString().slice(0, 10);
}

//Выбрать активный контракт
function SelectContract(tr) {
    SetSelectedContractFromTR(tr);
    CorrectToolbar(SelectedContract);
    WorkTable_SelectLine(tr);
}

//Сбросить активный контракт
function ResetContract() {
    ResetSelectedContract();
    CorrectToolbar();
    WorkTable_ClearSelection();
}

//Добавить новый контракт
function NewContract() {
    ContractAddEdit_Add();
}

//Изменить контракт
function EditContract(tr) {
    if (tr) {
        SetSelectedContractFromTR(tr);
    }
      
    ContractAddEdit_Edit(SelectedContract);
}

//Удалить контракт
function DeleteContract() {
    ContractDelete_Execute(SelectedContract);
}

//Поместить контракт в архив
function ToArchiveContract() {
    ToArchive_Execute(SelectedContract);
}

//Применить фильтр
function ApplyFilter(text = '') {
    Table_ApplyFilter(text);
}

window.onload = function(event) {
    CorrectToolbar();
}