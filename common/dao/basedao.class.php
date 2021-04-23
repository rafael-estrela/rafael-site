<?php

trait BaseDAO{
    private $con;

    public function __construct($con) {
        if ($con instanceof PDOConnection)
            $con = $con->instance();

        $this->con = $con;
    }

    public function insert($table, $values) {
        $sql = "INSERT INTO $table (";
        $sql .= $this->arrayWithCommas(array_keys($values));
        $sql .= ") VALUES (";
        $sql .= $this->arrayToQueryPlaceholders($values);
        $sql .= ");";

        $prep = $this->con->prepare($sql);

        $i = 0;

        foreach ($values as $v) {
            $i++;
            $prep->bindValue($i, $v);
        }

        $prep->execute();
    }

    public function retrieveAll(
        $table, $where = false,
        $columns = '*', $innerJoin = false,
        $on = false, $orderBy = false
    ){
        if ($columns === '*') {
            $sql = "SELECT * FROM $table";
        } else {
            $sql = "SELECT ".$this->arrayWithCommas($columns)." FROM $table";
        }

        if ($innerJoin !== false) $sql .= " INNER JOIN $innerJoin ON $on";

        if ($where !== false) {
            $sql .= " WHERE ".$this->arrayToWhere($where);
        }

        if ($orderBy !== false) {
            $sql = $sql." ORDER BY $orderBy";
        }

        $sql .= ';';

        $command = $this->con->prepare($sql);

        $i = 0;

        if ($where !== false) {
            foreach ($this->whereToValues($where) as $v) {
                $command->bindValue(++$i, $v);
            }
        }

        $command->execute();

        $assoc = array();

        while(($line = $command->fetch(PDO::FETCH_ASSOC)) !== false){
            $assoc[] = $line;
        }

        return $assoc;
    }

    public function count($table, $where) {
        $sql = "SELECT COUNT(*) FROM $table WHERE ".$this->arrayToWhere($where).';';

        $command = $this->con->prepare($sql);

        $i = 0;

        foreach($this->whereToValues($where) as $v) {
            $command->bindValue(++$i, $v);
        }

        $command->execute();

        return $command->fetchColumn();
    }

    public function countDaysInterval($table, $column, $days, $where) {
        $sql = "SELECT COUNT(*) FROM $table WHERE $column >= DATE(NOW()) - INTERVAL ? DAY AND ".$this->arrayToWhere($where).';';

        $command = $this->con->prepare($sql);

        $i = 0;

        $command->bindValue(++$i, $days);

        foreach($this->whereToValues($where) as $v) {
            $command->bindValue(++$i, $v);
        }

        $command->execute();

        return $command->fetchColumn();
    }

    function update($table, $values, $where) {
        $sql = "UPDATE $table SET ".$this->valuesToColumns(array_keys($values))." WHERE ".$this->arrayToWhere($where).';';

        $command = $this->con->prepare($sql);

        $i = 0;

        foreach($values as $v) {
            $command->bindValue(++$i, $v);
        }

        foreach($this->whereToValues($where) as $v) {
            $command->bindValue(++$i, $v);
        }

        $command->execute();
    }

    function increment($table, $column, $amount, $where) {
        $sql = "UPDATE $table SET $column = $column + $amount WHERE ".$this->arrayToWhere($where).';';

        $command = $this->con->prepare($sql);

        $i = 0;

        foreach($this->whereToValues($where) as $v) {
            $command->bindValue(++$i, $v);
        }

        $command->execute();
    }

    public function delete($table, $where){
        $sql = "DELETE FROM $table WHERE ".$this->arrayToWhere($where).';';

        $command = $this->con->prepare($sql);

        $i = 0;

        foreach ($this->whereToValues($where) as $v) {
            $command->bindValue(++$i, $v);
        }

        $command->execute();
    }

    private function arrayToQueryPlaceholders($array) {
        $placeholders = array_map(function () { return '?'; }, $array);

        return $this->arrayWithCommas($placeholders);
    }

    private function arrayWithCommas($array) {
        return $this->arrayWith(", ", $array);
    }

    private function arrayWith($divider, $array) {
        return implode($divider, $array);
    }

    private function arrayToWhere($queryItems) {
        $array = array();

        foreach($queryItems as $item) {
            $itemArray = explode(" ", $item);
            $array[] = "$itemArray[0] $itemArray[1] ?";
        }

        return $this->arrayWith(" AND ", $array);
    }

    private function valuesToColumns($columns) {
        return $this->arrayWithCommas(
            array_map(function($v) { return "$v = ?"; }, $columns)
        );
    }

    private function whereToValues($queryItems) {
        $array = array();

        foreach($queryItems as $item) {
            $itemArray = explode(" ", $item);
            unset($itemArray[0]);
            unset($itemArray[1]);

            $array[] = implode(" ", $itemArray);
        }

        return $array;
    }
}