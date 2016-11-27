<?php

/* 
 * Made by M4ciej
 */
class Connection
{
    private $connection;

    public function __construct(mysqli $mysqli)
    {
        if ($mysqli->connect_error) {
            throw new Exception($mysqli->connect_error);
        }
        $this->connection = $mysqli;
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);
        if ($result == false OR $this->connection->error) {
            throw new Exception($this->connection->error);
        }

        return $result;
    }

    public function insertSql($tableName, $listOfColumns, $listOfValues)
    {
        $list = [];

        foreach ($listOfValues as $value) {
            $list[] = $this->escapeString($value);
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $tableName,
            join(',', $listOfColumns),
            join(',', $list)
        );

        $this->query($sql);
    }

    public function getLastInsertedId()
    {
        return $this->connection->insert_id;
    }

    private function escapeString($string)
    {
        if (is_string($string)) {
            return sprintf('"%s"', $string);
        } else {
            return $string;
        }
    }

    public function updateSql($tableName, $listOfValue, $primaryKeyId)
    {
        $list = [];
        foreach ($listOfValue as $columnName => $value){
            $tempValue = $this->escapeString($value);
            $list[] = sprintf("%s=%s", $columnName, $tempValue);
        }

        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = %s",
            $tableName,
            join(',', $list),
            $primaryKeyId
            );

        $this->query($sql);
    }
    public function deleteSql($tableName, $id){
        $id=$this->escapeString($id);
        $sql="DELETE FROM ".$tableName." WHERE id=".$id;
        $this->query($sql);
    }
}
