<?php

namespace App\Modal;

class DatabaseModal
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "mvc-opdracht";
    private $conn = null;

    public function __construct()
    {
    }

    public function findAllByTable($tableName, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }
        if ($this->conn === null) {
            die("Query failed: " . $this->conn->error);
        }

        $tableName = $this->conn->real_escape_string($tableName);
        $query = "SELECT * FROM `$tableName`";
        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
        if ($persist) {
            $this->closeConnection();
        }
        return $data;
    }

    public function delete($tableName, $id, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }
        if ($this->conn === null) {
            die("Query failed: " . $this->conn->error);
        }
        $query = "DELETE FROM `$tableName` WHERE id = $id";

        $result = $this->conn->query($query);

        if ($persist) {
            $this->closeConnection();
        }
    }

    public function findBy($tableName, $conditions, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }

        if ($this->conn === null) {
            $this->openConnection();
        }

        $tableName = $this->conn->real_escape_string($tableName);
        $query = "SELECT * FROM `$tableName` WHERE ";

        $whereClauses = [];
        foreach ($conditions as $column => $value) {
            $column = $this->conn->real_escape_string($column);
            $value = $this->conn->real_escape_string($value);
            $whereClauses[] = "`$column` = '$value'";
        }

        $query .= implode(' AND ', $whereClauses);

        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
        if ($persist) {
            $this->closeConnection();
        }
        return $data;
    }

    public function findRelatedRecords($primaryTable, $relatedTable, $junctionTable, $primaryId, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }
        if ($this->conn === null) {
            $this->openConnection();
        }
        $this->openConnection();

        $primaryIdname = $primaryTable . "_id";
        $relatedIdName = $relatedTable . "_id";
        $query = "SELECT * FROM $relatedTable JOIN $junctionTable ON $relatedTable.id = $junctionTable.$relatedIdName WHERE $junctionTable.$primaryIdname = $primaryId;";

        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->close();
        if ($persist) {
            $this->closeConnection();
        }

        return $data;
    }

    public function saveEntity($entity, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }

        $entityClass = get_class($entity);

        $tableParts = explode('\\', $entityClass);
        $entityTable = end($tableParts);

        $entityTable = $this->conn->real_escape_string($entityTable);

        $data = (array)$entity;

        $id = isset($data['id']) ? $data['id'] : null;

        unset($data['id']);

        $columns = array_map([$this->conn, 'real_escape_string'], array_keys($data));
        $values = array_map([$this->conn, 'real_escape_string'], array_values($data));

        $columnList = implode(', ', $columns);
        $valueList = "'" . implode("', '", $values) . "'";

        if ($id !== null) {
            // Update existing record
            $updateValues = [];
            foreach ($columns as $index => $column) {
                $updateValues[] = "$column = '{$values[$index]}'";
            }
            $updateList = implode(', ', $updateValues);
            $query = "UPDATE `$entityTable` SET $updateList WHERE id = $id";
        } else {
            // Create new record
            $query = "INSERT INTO `$entityTable` ($columnList) VALUES ($valueList)";
        }

        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        if ($persist) {
            $this->closeConnection();
        }
    }
    public function findLastCreatedRecord($tableName, $orderByColumn = 'id', $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }

        if ($this->conn === null) {
            $this->openConnection();
        }

        $tableName = $this->conn->real_escape_string($tableName);
        $orderByColumn = $this->conn->real_escape_string($orderByColumn);

        $query = "SELECT * FROM `$tableName` ORDER BY `$orderByColumn` DESC LIMIT 1";

        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        $data = null;
        while ($row = $result->fetch_assoc()) {
            $data = $row;
        }

        $result->close();

        if ($persist) {
            $this->closeConnection();
        }

        return $data;
    }


    public function createRecord($tableName, $data, $persist = false)
    {
        if ($persist) {
            $this->openConnection();
        }

        if ($this->conn === null) {
            die("Query failed: " . $this->conn->error);
        }

        $tableName = $this->conn->real_escape_string($tableName);

        $columns = array_map([$this->conn, 'real_escape_string'], array_keys($data));
        $values = array_map([$this->conn, 'real_escape_string'], array_values($data));

        $columnList = implode(', ', $columns);
        $valueList = "'" . implode("', '", $values) . "'";

        $query = "INSERT INTO `$tableName` ($columnList) VALUES ($valueList)";

        $result = $this->conn->query($query);

        if ($result === false) {
            die("Query failed: " . $this->conn->error);
        }

        if ($persist) {
            $this->closeConnection();
        }
    }


    public function openConnection()
    {
        $this->conn = new \mysqli($this->servername, $this->username, $this->password, $this->database);
    }

    public function closeConnection()
    {
        $this->conn->close();
    }

}