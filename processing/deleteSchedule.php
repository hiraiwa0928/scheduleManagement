<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	if (!isset($_POST["id"])){
		header("Location: ../edit/injusticeAccess.php");
		exit;
	}else{
		try{
			$id = (int)$_POST["id"];
		}catch(Exception $e){
			header("Location: ../edit/injusticeAccess.php");
		}
	}

	$id = $_POST["id"];

	require_once "./dbConnect.php";
	$pdo = db_connect();

	try{
		$sql = <<<EOS
			DELETE FROM schedule
			WHERE id = :id
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":id", $id, PDO::PARAM_STR);
		$stmh->execute();
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$_SESSION["delete"] = true;

	header("Location: ../main/schedule.php");
?>