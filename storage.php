<?php

enum SortOrder: string {
    case Title = "Title";
    case SignDate = "SignDate";
    case PreparationDate = "PreparationDate";
    case Commentary = "Commentary";
}


class Storage {

    protected string $Host;
    protected int $Port;
    protected string $User;
    protected string $Password;
    protected string $DBName;
    protected $DBHandle = null;

    const TABLE_WORK = "work";    
    const TABLE_HISTORY = 'history';

    public function __construct(string $Host, int $Port, string $User, string $Password, string $DBName) {
        $this->Host = $Host;
        $this->Port = $Port;
        $this->User = $User;
        $this->Password = $Password;
        $this->DBName = $DBName;

        try {
            $this->DBHandle = new mysqli($this->Host, $this->User, $this->Password, $this->DBName, $this->Port);
            $this->DBHandle->set_charset('utf8mb4');
        } catch (Exception $e) {
            throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
        }
    }    

    public function GetContractList(SortOrder $Sort = SortOrder::Title): mixed {
        $req = $this->DBHandle->prepare("SELECT * FROM " . $this::TABLE_WORK . " ORDER BY " . $Sort->value);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }

        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function GetArchiveList(SortOrder $Sort = SortOrder::Title): mixed {
        $req = $this->DBHandle->prepare("SELECT * FROM " . $this::TABLE_HISTORY . " ORDER BY " . $Sort->value);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }

        return $req->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function AddContract(string $Title, DateTime $SignDate, DateTime $PreparationDate, int $ContractAmount, string $Commentary = "") {
        $sd = $SignDate->format('Y-m-d H:i:s');
        $pd = $PreparationDate->format('Y-m-d H:i:s');
        $req = $this->DBHandle->prepare("INSERT INTO " . $this::TABLE_WORK . " (Title, SignDate, PreparationDate, ContractAmount, Commentary) VALUES (?, ?, ?, ?, ?)");
        $req->bind_param("sssis", $Title, $sd, $pd, $ContractAmount, $Commentary);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }
    }

    public function DeleteContract(int $ID) {
        $req = $this->DBHandle->prepare("DELETE FROM " . $this::TABLE_WORK . " WHERE ID=?");
        $req->bind_Param("i", $ID);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }
    }

    public function EditContract(int $ID, string $Title, DateTime $SignDate, DateTime $PreparationDate, int $ContractAmount, string $Commentary = "") {

        $sd = $SignDate->format('Y-m-d H:i:s');
        $pd = $PreparationDate->format('Y-m-d H:i:s');

        $req = $this->DBHandle->prepare("UPDATE " . $this::TABLE_WORK . " SET Title=?, SignDate=?, PreparationDate=?, ContractAmount=?, Commentary=? WHERE ID=?");
        $req->bind_param("sssisi", $Title, $sd, $pd, $ContractAmount, $Commentary, $ID);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }
    }

    public function ToArchive(int $ID, DateTime $ActSignDate) {
        //Прочитать данные из таблицы по ID
        $req = $this->DBHandle->prepare("SELECT * FROM " . $this::TABLE_WORK . " WHERE ID=?");
        $req->bind_param("i", $ID);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }

        //Разобрать данные
        $Data = $req->get_result()->fetch_array(MYSQLI_ASSOC);

        //Удалить из одной таблицы
        $this->DeleteContract($ID);

        //Добавить в архив
        $asd = $ActSignDate->format('Y-m-d H:i:s');
        $req = $this->DBHandle->prepare("INSERT INTO " . $this::TABLE_HISTORY . " (Title, SignDate, PreparationDate, ContractAmount, Commentary, ActSignDate) VALUES (?, ?, ?, ?, ?, ?)");
        $req->bind_Param("sssiss", $Data['Title'], $Data['SignDate'], $Data['PreparationDate'], $Data['ContractAmount'], $Data['Commentary'], $asd);

        if (!$req->execute()) {
            throw new Exception($this->DBHandle->error, $this->DBHandle->errno);
        }
    }

}


?>