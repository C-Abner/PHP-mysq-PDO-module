<?php
	class mysqldb {
		
		var $conn;
		
		function mysqldb(){
			$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset='.DB_CHARSET.';port='.DB_PORT;
			$option = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
			);
			try{
				$this->conn = new PDO( $dsn, DB_USER, DB_PASS, $option );
				}catch (PDOExpention $e){
				$err_msg = "DB connect faild". $e->getMessage();
				echo $err_msg;
			}
		}
		
		/**
			close db connnect.
		**/
		function close(){
			$this->conn->close();
		}
		
		/**
			SQL execute
		**/
		function execute( $sql, $params=null ){
			$stmt = $this->conn->prepare($sql);
			while (list($key, $value) = @each($params)) {
				$stmt->bindParam($key+1, $value[0], $value[1]);
			}
			$stmt->execute();
			return $stmt;
		}
		
		/**
			SQL get data
		**/
		function getall( $sql, $params=null ){
			$stmt = $this->execute( $sql, $params );
			while ($row = $stmt->fetch()) {
				$ret[] = $row;
			}
			return $ret;
		}
		
		/**
			only return one of first data
		**/
		function getfirst( $sql, $params=null ){
			$stmt = $this->execute( $sql, $params );
			return $stmt->fetch();
		}
		
		/**
			get the last inserted id
		**/
		function insertid(){
			return $this->conn->lastInsertId();
		}

		/**
			* not safe SQL security
		**/
		function getallQ( $sql){
			$stmt = $this->conn->query($sql);
			while ($row = $stmt->fetch()) {
				$ret[] = $row;
			}
			return $ret;
		}
		
		/**
			* SQL begin feature
		**/
		function begin(){
			$this->conn->beginTransaction();
		}
		
		/**
			* SQL rollback feature
		**/
		function rollback(){
			$this->conn->rollback();
		}
		
		/**
			* SQL commit feature
		**/
		function commit(){
			$this->conn->commit();
		}
	}
	
	
?>
