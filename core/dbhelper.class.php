<?php

class DbHelper
{
    private static $dbhelper = null;
    private $conn = null;
    
    public static function GetDbHelper()
    {
        if (self::$dbhelper == null)
        {
            self::$dbhelper = new DbHelper();
        }
        
        return self::$dbhelper;
    }
    
    public function GetDbConn()
    {
        return $this->conn;
    }
    
    public function __construct()
    {
        $this->conn = mysql_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PASS);
        if (!$this->conn) die('mysql_connect');
        if (!mysql_select_db(DB_BASE, $this->conn)) die('mysql_select_db');
        
        mysql_query('SET NAMES ' . DB_SET, $this->conn);
    }
    
    public function __destruct()
    {
        if ($this->conn)
        {
            mysql_close($this->conn);
        }
    }
    
    public function query($sql)
    {
        return mysql_query($sql, $this->conn);
    }
    
    // $op == MYSQL_BOTH MYSQL_ASSOC MYSQL_NUM
    public function fetch($rs, $op = MYSQL_BOTH)
    {
        return mysql_fetch_array($rs, $op);
    }
    
    // 释放结果集
    public function freeResult($rs)
    {
        return mysql_free_result($rs);
    }
    
    // insert update delete 影响行数
    public function affectedRows()
    {
        return mysql_affected_rows($this->conn);
    }
    
    // 最新插入行的ID值
    public function insertId()
    {
        return mysql_insert_id($this->conn);
    }
    
    // 返回查询结果集行数
    public function numRows($rs)
    {
        return mysql_num_rows($rs);
    }
    
    // 返回查询结果集列数
    public function numFields($rs)
    {
        return mysql_num_fields($rs);
    }
    
    // 返回字段名
    public function FieldName($rs, $off)
    {
        return mysql_field_name($rs, $off);
    }
    
    ////////////////////
    /* 辅助功能的实现 */
    ////////////////////
    
    // 获取一条详细记录
    public function select($table, $id, $op = MYSQL_ASSOC)
    {
        $rs = $this->query("select * from `{$table}` where `id` = {$id}");
        $row =  $this->fetch($rs, $op);
        $this->freeResult($rs);
        return $row;
    }
    
    // 删除一条记录
    public function delete($table, $id)
    {
        return $this->query("delete from `{$table}` where `id` = {$id}");
    }
    
    // 获取字段数据类型
    public function getFieldType($table, $fieldname)
    {
        $sql = "select * from `information_schema`.`COLUMNS` where `TABLE_SCHEMA` = '" . DB_BASE . "' and `TABLE_NAME` = '{$table}' and `COLUMN_NAME` = '{$fieldname}'";
        $rs = $this->query($sql);
        $row = $this->fetch($rs, MYSQL_ASSOC);
        $this->freeResult($rs);
        return $row['DATA_TYPE'];
    }
    
    // 获取表中所有字段的数据类型
    public function getTableFieldTypeList($table)
    {
        $sql = "select `COLUMN_NAME`,`DATA_TYPE` from `information_schema`.`COLUMNS` where `TABLE_SCHEMA` = '" . DB_BASE . "' and `TABLE_NAME` = '{$table}'";
        $rs = $this->query($sql);
        $arr = array();
        while ($row = $this->fetch($rs, MYSQL_NUM))
        {
            $arr[$row[0]] = $row[1];
        }
        $this->freeResult($rs);
        return $arr;
    }
    
    // 插入一条记录 $table(string) $fieldsValues[$key] = $val 成功返回新插入的ID值 失败返回false
    public function insert($table, $fieldsValues)
    {
        $fieldstr = '';
        $valuestr = '';
        
        $arr = $this->getTableFieldTypeList($table);
        
        foreach ($fieldsValues as $key => $val)
        {
            $fieldstr .= "`{$key}`, ";
            if ($arr[$key] == 'int')
            {
                $valuestr .= "{$val}, ";
            }
            else
            {
                $valuestr .= "'{$val}', ";
            }
        }
        $fieldstr = rtrim($fieldstr, ', ');
        $valuestr = rtrim($valuestr, ', ');
        
        $sql = "insert into `{$table}`({$fieldstr}) values({$valuestr})";
        if ($this->query($sql))
        {
            return $this->insertId();
        }
        
        return false;
    }
    
    // 更新一条记录
    public function update($table, $fieldsValues, $id)
    {
        $str = '';
        $arr = $this->getTableFieldTypeList($table);
        foreach ($fieldsValues as $key => $val)
        {
            $str .= "`{$key}` = ";
            if ($arr[$key] == 'int')
            {
                $str .= "{$val}, ";
            }
            else
            {
                $str .= "'{$val}', ";
            }
        }
        $str = rtrim($str, ', ');
        
        $sql = "update `{$table}` set {$str} where `id` = $id";
        return $this->query($sql);
    }
    
    // 获取表的总记录数
    public function GetCount($table, $where = null)
    {
        $sql = '';
        if ($where == null)
        {
            $sql = "select count(0) from `{$table}`";
        }
        else
        {
            $sql = "select count(0) from `{$table}` where {$where}";
        }
        $rs = $this->query($sql);
        $row = $this->fetch($rs, MYSQL_NUM);
        $this->freeResult($rs);
        return $row[0];
    }
    
    // 获取记录列表 $where = "`id` > 1 order by `id` desc" 返回二维数组
    public function GetList($table, $where = null, $fields = "*")
    {
        $sql = '';
        if ($where == null)
        {
            $sql = "select {$fields} from `{$table}`";
        }
        else
        {
            $sql = "select {$fields} from `{$table}` where {$where}";
        }
        $rs = $this->query($sql);
        $arrReturn = array();
        while ($row = $this->fetch($rs, MYSQL_ASSOC))
        {
            array_push($arrReturn, $row);
        }
        $this->freeResult($rs);
        return $arrReturn;
    }
    
    // 获取分页记录 返回二维数组
    public function GetListByPage($table, $page, $pagesize = 10, $where = null, $fields = "*")
    {
        $page = intval($page);
        $pagesize = intval($pagesize);
        $count = $this->GetCount($table);
        $total = ceil((float)$count / $pagesize);
        
        if ($page < 1) $page = 1;
        if ($page > $total) $page = $total;
        
        $start = ($page - 1) * $pagesize;
        
        $sql = '';
        if ($where == null)
        {
            $sql = "select {$fields} from `{$table}` limit {$start},{$pagesize}";
        }
        else
        {
            $sql = "select {$fields} from `{$table}` where {$where} limit {$start},{$pagesize}";
        }
        $rs = $this->query($sql);
        $arrReturn = array();
        while ($row = $this->fetch($rs, MYSQL_ASSOC))
        {
            array_push($arrReturn, $row);
        }
        $this->freeResult($rs);
        return $arrReturn;
    }
}

























