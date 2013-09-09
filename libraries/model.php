<?php
class Model {

	public static $conn;

	function __construct(){
		$this->db_connection();
	}
	public function db_connection() {
		try{
			self::$conn = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		}catch(PDOException $e){
			echo "Erro while making PDO connection" . $e->getMessage();
		}
		
	}

	public static function find_one($query) {
		try{
			$result = self::$conn->query($query);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			if($row){
				return $row;
			}else{
				echo "Either zero or more than one records found in find_one method";
				exit();
			}
		}catch(PDOException $e){
			echo "Erro while in find_one method" . $e->getMessage();
			exit();
		}
	}

	public static function find_many($query) {
		try{
			$result = self::$conn->query($query);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			if($rows){
				return $rows;
			}else{
				echo "zero records found in find_many method";
				exit();
			}
		}catch(PDOException $e){
			echo "Error while in find_many method" . $e->getMessage();
			exit();
		}
	}

	public static function save($query){
		try{
			$sth = self::$conn->prepare($query);
			$bool = $sth->execute();
			return $bool;
		 }catch(PDOException $e){
			echo "Error while in find_many method" . $e->getMessage();
			exit();
		}	
	}
}	

new Model();