<?php

class database 
{
    
    private $pdo;
    
    function __construct()
    {
        $pr = new properties();
        $dsn = 'mysql:dbname=' . $pr->db_name . ';host=' . $pr->db_host .
                ';charset=utf8';
        try {
            $this->pdo = new PDO($dsn, $pr->db_login, $pr->db_pass);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }    
    
    //data format is an array (array with the column name, array with the data)
    public function insert($table, array $data)
    {
        $cols = '';
        $ins = '';
        
        foreach($data[0] as $c) {
            $cols .= '`'.$c.'`, ';
        }
        $cols = substr($cols, 0, -2);

        foreach($data[1] as $i) {
            $ins .= "'".$i."', ";
        }
        $ins = substr($ins, 0, -2);
        
        $string = "INSERT INTO `$table` ($cols) VALUES ($ins)";
        if($this->pdo->exec($string) == 0) { 
            print_r($this->pdo->errorInfo());
            return false;
        }
        return true;
    }
    
    //update a specific line in a table
    public function update($table, $column, $data, $where_col, $where_res)
    {   
        $string = "UPDATE `$table` SET `$column` = '$data' WHERE `$where_col` = '$where_res'";
        if($this->pdo->exec($string) == 0) return false;
        return true;
    }
    
    //remove a specific line in a table
    public function remove($table, $where_col, $where_res)
    {   
        $string = "DELETE FROM `$table` WHERE `$where_col` = '$where_res'";
        if($this->pdo->exec($string) == 0) return false;
        return true;
    }
    
    /* Data format:
     * table: string (table name)
     * column_arr: array (contains list of columns for updating)
     * data_arr: array (contains list of values of updating columns)
     * where_col: where condition (column name)
     * where_res: where condition (value)
     */
    public function multi_update($table, $column_arr, $data_arr, $where_col, $where_res)
    {   
        $data = '';
        for ($i = 0; $i < count($column_arr); $i++) {
            $data .= '`'.$column_arr[$i]."` = '".$data_arr[$i]."', ";
        }
        $data = substr($data, 0, -2);
        
        $string = "UPDATE `$table` SET $data WHERE `$where_col` = '$where_res'";
        if($this->pdo->exec($string) == 0) return false;
        return true;
    }
    
    // returns an array made from a particular table
    public function select_all($table)
    {
        $string = "SELECT * FROM `$table`";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            return $pdo->fetchAll(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    /* returns an onedimensional array from a table with a particular row
     * If all = 1, returns a multidimensional array with conditions where
     */
    public function select_where($table, $where_col, $where_res, $all = 0)
    {
        $string = "SELECT * FROM `$table` WHERE `$where_col` = '$where_res'";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            if($all == 1) {
                return $pdo->fetchAll(PDO::FETCH_ASSOC);
            } else return $pdo->fetch(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    // returns selected collums. 
    // Columns should be an array with the list of column names
    public function select_columns_all($table, $columns)
    {
        $data = '';
        for ($i = 0; $i < count($columns); $i++) {
            $data .= '`'.$columns[$i].'`, ';
        }
        $data = substr($data, 0, -2);
        
        $string = "SELECT $data FROM `$table`";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            return $pdo->fetchAll(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    public function select_cols_where($table, $columns, $where_col, $where_res, $all = 0)
    {
        $data = '';
        for ($i = 0; $i < count($columns); $i++) {
            $data .= '`'.$columns[$i].'`, ';
        }
        $data = substr($data, 0, -2);
        
        $string = "SELECT $data FROM `$table` WHERE `$where_col` = '$where_res'";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            if($all == 1) {
                return $pdo->fetchAll(PDO::FETCH_ASSOC);
            } else return $pdo->fetch(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    public function select_multi_where($table, $where_col_arr, $where_res_arr, $all = 0, $sort_column = 0)
    {
        $where = '';
        for ($i = 0; $i < count($where_col_arr); $i++) {
            $where .= '`'.$where_col_arr[$i]."` = '".$where_res_arr[$i]."' AND ";
        }
        $where = substr($where, 0, -5);
        $sort = '';
        if($sort_column !== 0) {
            $sort = "ORDER BY $sort_column";
        }

        $string = "SELECT * FROM `$table` WHERE $where $sort";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            if($all == 1) {
                return $pdo->fetchAll(PDO::FETCH_ASSOC);
            } else return $pdo->fetch(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    public function select_complex($table, $columns, $where_col_arr, $where_res_arr, $all = 0, $sort_column = 0)
    {
        $where = '';
        for ($i = 0; $i < count($where_col_arr); $i++) {
            $where .= '`'.$where_col_arr[$i]."` = '".$where_res_arr[$i]."' AND ";
        }
        
        $where = substr($where, 0, -5);
        $sort = '';
        if($sort_column !== 0) {
            $sort = "ORDER BY $sort_column";
        }
        
        $data = '';
        for ($i = 0; $i < count($columns); $i++) {
            $data .= '`'.$columns[$i].'`, ';
        }
        $data = substr($data, 0, -2);
        
        $string = "SELECT $data FROM `$table` WHERE $where $sort";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            if($all == 1) {
                return $pdo->fetchAll(PDO::FETCH_ASSOC);
            } else return $pdo->fetch(PDO::FETCH_ASSOC);
        } else return false;
    }
    
    public function select_cols_range($table, $columns, $where_col, $start, $end, $all = 0)
    {
        $data = '';
        for ($i = 0; $i < count($columns); $i++) {
            $data .= '`'.$columns[$i].'`, ';
        }
        $data = substr($data, 0, -2);
        
        $string = "SELECT $data FROM `$table` WHERE `$where_col` <= '$end' AND `$where_col` >= $start";
        $pdo = $this->pdo->prepare($string);
        if ($pdo->execute()) {
            if($all == 1) {
                return $pdo->fetchAll(PDO::FETCH_ASSOC);
            } else return $pdo->fetch(PDO::FETCH_ASSOC);
        } else return false;
    }
}