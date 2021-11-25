<?php
	session_start();

	require_once "./dbConnect.php";
	$pdo = db_connect();

	$inputUserName = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES);
	$inputPassword = htmlspecialchars(trim($_POST["password"]), ENT_QUOTES);

	$password = "";

	try{
		$sql = <<<EOS
			SELECT * FROM member
			WHERE username = :username
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $inputUserName, PDO::PARAM_STR);
		$stmh->execute();
		while($result = $stmh->fetch(PDO::FETCH_ASSOC)){
			$password = $result["password"];
		}
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}
	$pdo = null;

	if ($password != "" && $password == hash("sha256", $inputPassword)){
		$_SESSION["username"] = $inputUserName;
		header("Location: ../main/schedule.php");
	}else{
		header("Location: ../index.php?username=" . $inputUserName);
	}
?>