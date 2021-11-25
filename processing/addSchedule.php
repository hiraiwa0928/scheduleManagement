<?php
	require_once "../processing/getFormData.php";

	$display = $_POST["display"];
	$showWeekPage = $_POST["showWeekPage"];
	$showMonthPage = $_POST["showMonthPage"];

	if (strcmp($start, $finish) >= 0){
		$_SESSION["timeError"] = true;
		$_SESSION["place"] = $place;
		$_SESSION["contents"] = $contents;

		header("Location: ../main/schedule.php?display=" . $display. "&showWeekPage=" . $showWeekPage . "&showMonthPage=" . $showMonthPage);
		exit;
	}

	try{
		$sql = <<<EOS
			INSERT INTO schedule(
				username,
				start,
				finish,
				place,
				contents
			)
			VALUES(
				:username,
				:start,
				:finish,
				:place,
				:contents
			)
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $username, PDO::PARAM_STR);
		$stmh->bindValue(":start", $start, PDO::PARAM_STR);
		$stmh->bindValue(":finish", $finish, PDO::PARAM_STR);
		$stmh->bindValue(":place", $place, PDO::PARAM_STR);
		$stmh->bindValue(":contents", $contents, PDO::PARAM_STR);
		$stmh->execute();

	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$_SESSION["success"] = true;
	unset($_SESSION["place"]);
	unset($_SESSION["contents"]);

	header("Location: ../main/schedule.php?display=" . $display. "&showWeekPage=" . $showWeekPage . "&showMonthPage=" . $showMonthPage);
?>