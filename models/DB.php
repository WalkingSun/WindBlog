<?php
namespace app\models;

class DB
{

    public $db='db';

    public function __construct()
    {

        $this->db = \Yii::$app->db;
    }

    public  function query($sql){
		return $this->db->createCommand($sql)->execute();
	}

	public  function get_one($sql, $type = ''){
		$r = $this->db->createCommand($sql)->queryRow();
		if($type)return (object)$r;
		return $r;
	}
	 
	public   function get_column($sql){
	    $r =  $this->db->createCommand($sql)->queryColumn();
	    return $r;
	}
	
	public   function get_scalar($sql){
	    $r =  $this->db->createCommand($sql)->queryScalar();
	    return $r;
	}

	public   function get_all($sql){
        $data =  $this->db->createCommand($sql)->queryAll();
		return $data;
	}

	public   function insertid(){
        return  $this->db->getLastInsertID();
	}

	public   function nums($sql){
		return count( $this->db->createCommand($sql)->queryAll());
	}
	static function implode_field_value($array, $glue = ',') {
		$sql = $comma = '';
		foreach ($array as $k => $v) {
			$sql .= $comma."\"$k\"=\"$v\"";
			$comma = $glue;
		}
		return $sql;
	}

	public  function insert($table, $data, $return_insert_id = false, $replace = false, $silent = false) {
         $result = $this->db->createCommand()->insert($table,$data)->execute();
//	    $sql = DB::implode_field_value($data);
//		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
//		$silent = $silent ? 'SILENT' : '';
//		DB::query("$cmd \"$table\" SET $sql", $silent);
        return $result;
	}

	public  function update($table, $data, $condition) {
        $result = $this->db->createCommand()->update($table,$data,$condition)->execute();
		return $result;
	}

	public  function updateSql($sql) {
        $result = $this->db->createCommand($sql)->execute();
		return $result;
	}

	public function batchInsert( $table, $data ){
        $result = $this->db->createCommand()->batchInsert($table, array_keys($data[0]), $data)->execute();
        return $result;
    }

    //绑定插入
    public function bindInsert( $table,$data ){
	    foreach ($data as $k => $v){
            $param[$k] = ':'.$k;
            $bind[':'.$k] = $v;
        }
        $str1 = "\"".implode("\",\"",array_keys($param))."\"";
        $str2 = implode(",",array_values($param));
        $sql = "INSERT INTO \"{$table}\" ({$str1}) VALUES ($str2)";
        $result = $this->db->createCommand($sql)->bindValues($bind)->execute();
        return $result;
    }
}