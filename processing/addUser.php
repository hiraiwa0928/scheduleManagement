<?php
	require_once "./dbConnect.php";
	$pdo = db_connect();

	$username = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES);
	$password = htmlspecialchars(trim($_POST["password"]), ENT_QUOTES);
	$password_confirm = htmlspecialchars(trim($_POST["password_confirm"]), ENT_QUOTES);

	if (!(3 <= strlen($username) && strlen($username) <= 20)){
		header("Location: ../user/resultRegist.php?judge=false");
		exit;
	}

	if(!(8 <= strlen($password) && strlen($password) <= 128)){
		header("Location: ../user/resultRegist.php?judge=false");
		exit;
	}

	try{
		$sql = <<<EOS
			SELECT * FROM member
			WHERE username = :username
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $username, PDO::PARAM_STR);
		$stmh->execute();
		$count = $stmh->rowCount();
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	if ($password != $password_confirm || $count > 0){
		header("Location: ../user/resultRegist.php?judge=false");
		exit;
	}

	try{
		$sql = <<<EOS
			INSERT INTO member(
				username,
				password
			)
			VALUES(
				:username,
				:password
			)
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $username, PDO::PARAM_STR);
		$stmh->bindValue(":password", hash("sha256", $password), PDO::PARAM_STR);
		$stmh->execute();
		
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$pdo = null;

	header("Location: ../user/resultRegist.php?judge=true");
?>