<?php
define("HOST", "localhost");
define("DB_NAME", "store_book"); 
define("DB_USER", "root");
define("DB_PASS", "");
define('ROOT', dirname(dirname(__FILE__) ) );
define("BASE_URL", "http://".$_SERVER['SERVER_NAME']."/TTTN/");
class DB{
    private $count_row;
    private $db_connect = null;
    public function __construct() {
        $drive="mysql:host=". HOST . ";dbname=". DB_NAME;
        try{
            $this->db_connect = new PDO($drive, DB_USER, DB_PASS);
            $this->db_connect->query("SET NAMES 'utf8'");
        }
        catch(PDOException $e){
            echo "Err: ". $e->getMessage();
            exit();
        }
    }
    public function __destruct() {
        $this->db_connect = null;
    }
    public function getRowcount(){
        return $this->count_row;
    }
    private function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC){
			$stm = $this->db_connect->prepare($sql);
		if (!$stm->execute( $arr)) {
			echo "Sql lỗi thực thi."; exit;	
		}
		$this->count_row = $stm->rowCount();
		return $stm->fetchAll($mode);
			
	}
    public function select($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC){
		return $this->query($sql, $arr, $mode);	
		}
		
	public function insert($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC){
		$this->query($sql, $arr, $mode);	
		return $this->db_connect->lastInsertId();
	}
		
	public function update($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC){
		$this->query($sql, $arr, $mode);	
		return $this->getRowCount();
	}
		
	public function delete($sql,  $arr = array(), $mode = PDO::FETCH_ASSOC){
		$this->query($sql, $arr, $mode);	
		return $this->getRowCount();
	}
}
?>