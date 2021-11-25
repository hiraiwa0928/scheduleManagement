<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	if (!isset($_GET["id"]) || !isset($_SESSION["username"])){
		header("Location: ../edit/injusticeAccess.php");
	}else{
		try{
			$id = (int)$_GET["id"];
		}catch(Exception $e){
			header("Location: ../edit/injusticeAccess.php");
		}
	}

	require_once "../processing/dbConnect.php";
	$pdo = db_connect();

	try{
		$sql = <<<EOS
			SELECT username FROM schedule
			WHERE id = :id
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":id", $id, PDO::PARAM_INT);
		$stmh->execute();

		if ($stmh->fetch()["username"] != $_SESSION["username"]){
			header("Location: ../edit/injusticeAccess.php");
		}

	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}
?>