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
    value = (Contract == null) ? "hidden" : "visible";

    document.getElementById("ToolBtnEdit").style.visibility = value;
    document.getElementById("ToolBtnDelete").style.visibility = value;
    document.getElementById("ToolBtnArchive").style.visibility = value;
}

//Вернуть текущую дату
function GetCurrentDate() {
    return new Date().toISOString().slice(0, 10);
}

//Выбрать активный контракт
function SelectContract(tr) {
    SetSelectedContractFromTR(tr);
    CorrectToolbar(SelectedContract);
    DataTable_SelectLine(tr);
}

//Сбросить активный контракт
function ResetContract() {
    ResetSelectedContract();
    CorrectToolbar();
    DataTable_ClearSelection();
}

//Добавить новый контракт
function NewContract() {
    ModalEditor_Add();
}

//Изменить контракт
function EditContract(tr) {
    if (tr) {
        SetSelectedContractFromTR(tr);
    }
      
    ModalEditor_Edit(SelectedContract);
}

//Удалить контракт
function DeleteContract() {
    ModalQuestion_Delete(SelectedContract);
}

//Поместить контракт в архив
function ToArchiveContract() {
    ModalArchive_ToArchive(SelectedContract);
}


window.onload = function(event) {
    CorrectToolbar();
}

