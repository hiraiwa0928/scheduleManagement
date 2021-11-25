<?php
	require_once "../processing/getFormData.php";

	$id = $_POST["id"];

	if (strcmp($start, $finish) >= 0){
		$_SESSION["timeError"] = true;
		$_SESSION["place"] = $place;
		$_SESSION["contents"] = $contents;

		header("Location: ../edit/showEditSchedule.php?id=" . $id);
		exit;
	}

	try{
		$sql = <<<EOS
			UPDATE schedule
			SET
				start = :start,
				finish = :finish,
				place = :place,
				contents = :contents
			WHERE id = :id
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":start", $start, PDO::PARAM_STR);
		$stmh->bindValue(":finish", $finish, PDO::PARAM_STR);
		$stmh->bindValue(":place", $place, PDO::PARAM_STR);
		$stmh->bindValue(":contents", $contents, PDO::PARAM_STR);
		$stmh->bindValue(":id", $id, PDO::PARAM_INT);
		$stmh->execute();

	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$_SESSION["edit"] = true;
	unset($_SESSION["place"]);
	unset($_SESSION["contents"]);

	header("Location: ../main/schedule.php");
?>