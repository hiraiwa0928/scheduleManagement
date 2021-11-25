<?php
	function db_connect(){
		$db_user = "root";
		$db_pass = "root";
		$db_host = "localhost";
		$db_name = "schedule_management";
		$db_type = "mysql";

		$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

		try{
			$pdo = new PDO($dsn, $db_user, $db_pass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}catch(PDOException $Exception){
			die("接続エラー:".$Exception->getMessage());
		}

		return $pdo;
	}
?>