<?php
class Database extends PDO
{
    private $rows = 0;
    public function __construct($DB_TYPE = '', $DB_HOST = '', $DB_NAME = '', $DB_USER = '', $DB_PASS = '')
    {
        if ($DB_TYPE == '' && $DB_HOST == '') {
            $DB_TYPE = DB_TYPE;
            $DB_HOST = DB_HOST;
            $DB_NAME = DB_NAME;
            $DB_USER = DB_USER;
            $DB_PASS = DB_PASS;
        }
        //echo "$DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS";
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        //parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
        //parent::setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
    }

    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select1($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        //print_r($array);
        //exit;
        if (!is_array($array)) {
            $array = array();
        }
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();
        //print_r($sth);
        return $sth->fetchAll($fetchMode);
    }
    public function select($table, $data, $order_field = '', $sorting, $limit = 0, $fetchMode = PDO::FETCH_ASSOC)
    {
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key AND";
        }
        $fieldDetails = rtrim($fieldDetails, 'AND');

        if ($limit == 0) {
            $limit_fin = '';
        } else {
            $limit_fin = " LIMIT $limit";
        }
        if ($order_field == '') {
            $order_fin = '';
        } else {
            $order_fin = " ORDER BY $order_field $sorting";
        }
        $sth = $this->prepare("select * from $table WHERE $fieldDetails $order_fin $limit_fin");

        $SQL = "select * from $table WHERE $fieldDetails $order_fin $limit_fin";

        // exit;
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    public function Execute($sql, $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        $sth->execute();
        $this->rows = $sth->rowCount();
        return $sth->fetchAll($fetchMode);
    }
    public function Execute_limit($sql, $limit, $fetchMode = PDO::FETCH_ASSOC)
    {
        $sql .= " LIMIT :skip, :max";
        $sth = $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sth = $this->prepare($sql);
        $sth->bindValue(':skip', 0, PDO::PARAM_INT);
        $sth->bindValue(':max', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }
    public function get_table_array($sql, $array = array(), $key = '', $arr_value = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        if (!is_array($array)) {
            $array = array();
        }
        $sth = $this->prepare($sql);
        foreach ($array as $key1 => $value) {
            $sth->bindValue("$key1", $value);
        }

        $sth->execute();
        $arr_tmp = $sth->fetchAll($fetchMode);
        //print_r($arr_tmp);
        //exit;
        $return_arr = array();
        if ($arr_value == '*') {
            //$return_arr = $arr_tmp;
            foreach ($arr_tmp as $value) {
                $return_arr[$value[$key]] = $value;
            }
        } else {
            if (count($arr_value) == 1) {
                //echo 123;
                //exit;
                $value_key = $arr_value[0];
                foreach ($arr_tmp as $value) {
                    $return_arr[$value[$key]] = $value[$value_key];
                }
            } else {
                foreach ($arr_tmp as $value) {
                    # code...
                    foreach ($arr_value as $table_column) {
                        $return_arr[$value[$key]][$table_column] = $value[$table_column];
                    }

                }
            }

        }

        // print_r($return_arr);
        // exit;
        return $return_arr;
    }
    public function PageExecute($sql, $limit = __DATA_PER_PAGE, $page = 1, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {

        if (!is_array($array)) {
            $array = array();
        }

        $total_num = $this->getTotal($sql, $array);
//        echo $total_num;
//        exit;
        $total_page = ceil($total_num / $limit);
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $total_page) {
            $page = $total_page;
        }
        $start = ($page - 1) * $limit;
        $sql .= " LIMIT ?,?";
        $sth = $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute(array($start, $limit));
        return $sth->fetchAll($fetchMode);
    }
    private function getTotal($sql, $array = array())
    {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }
        $sth->execute();
        $count = $this->rows = $sth->rowCount();
        return $count;
    }
    public function Affected_Rows()
    {
        return $this->rows;
    }
    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        // echo "INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)";
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        return $this->lastInsertId();
        //$a = $sth->fetch(PDO::FETCH_ASSOC);
        //print_r($a);
        //exit;
        //return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;
        $SQL = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
            $SQL .= "`$key`=$value,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        // if (Func::get_client_ip() == "114.46.51.8") {
        //     echo "UPDATE $table SET $SQL WHERE $where";
        //     exit;
        // }

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $a = $sth->execute();
        //echo 'a = ' . $a;
        //exit;
    }

    /**
     * delete
     *
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }

    public function delete_all($table, $where)
    {
        return $this->exec("DELETE FROM $table WHERE $where");
    }

    public function find1($table, $where, $limit = 1)
    {
        //print_r($_SESSION);
        //echo "select * from $table WHERE $where limit $limit";
        //exit;
        $sth = $this->prepare("select * from $table WHERE $where limit $limit");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $count = $sth->rowCount();
        if ($count > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function find($table, $data, $limit = 1, $fetchMode = PDO::FETCH_ASSOC)
    {
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key AND";
        }
        $fieldDetails = rtrim($fieldDetails, 'AND');

        $sth = $this->prepare("select * from $table WHERE $fieldDetails LIMIT $limit");
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    protected $transactionCount = 0;

    public function beginTransaction()
    {
        if (!$this->transactionCounter++) {
            return parent::beginTransaction();
        }
        $this->exec('SAVEPOINT trans' . $this->transactionCounter);
        return $this->transactionCounter >= 0;
    }

    public function commit()
    {
        if (!--$this->transactionCounter) {
            return parent::commit();
        }
        return $this->transactionCounter >= 0;
    }

    public function rollback()
    {
        if (--$this->transactionCounter) {
            $this->exec('ROLLBACK TO trans' . $this->transactionCounter + 1);
            return true;
        }
        return parent::rollback();
    }

}
