<?php
	require_once "./dbConnect.php";
	$pdo = db_connect();

	$inputUserName = $_POST["username"];

	try{
		$sql = <<<EOS
			SELECT * FROM member
			WHERE username = :username
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $inputUserName, PDO::PARAM_STR);
		$stmh->execute();
		$count = $stmh->rowCount();
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$pdo = null;

	if ($count < 1){
		echo true;
	}else{
		echo false;
	}
?>