<?php

	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	require_once "../processing/dbConnect.php";
	$pdo = db_connect();

		// 今週の日曜日の日付と月曜日の日付を返す
	function getWeekStartAndEndDate($checkData){
		$result = array(
			'startDate' => null,
			'finishDate'   => null,
		);

		$weekNo = date('w', strtotime($checkData));

		// 週の初めの年月日を取得
		$result['startDate'] = date('Y/m/d', strtotime("-{$weekNo} day", strtotime($checkData)));

		// 週の最後の年月日を取得
		$daysLeft          = 6 - $weekNo;
		$result['finishDate'] = date('Y/m/d', strtotime("+{$daysLeft} day", strtotime($checkData)));

		return $result;
	}

	try{
		$showWeekPage = (int)$_GET["showWeekPage"];
	}catch(Exception $e){
		$showWeekPage = 0;
	}finally{
		$showWeekPage_json = json_encode($showWeekPage);
	}

	try{
		$showMonthPage = (int)$_GET["showMonthPage"];
	}catch(Exception $e){
		$showMonthPage = 0;
	}finally{
		$showMonthPage_json = json_encode($showMonthPage);
	}

	// ALLの取得
	$allData = [];
	try{
		$sql = <<<EOS
			SELECT * FROM schedule
			WHERE username = :username
			ORDER BY start ASC
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
		$stmh->execute();

		while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
			$subDate = [];
			foreach($row as $key => $value){
				if ($key == "start" || $key == "finish"){
					$subDate[$key] = htmlspecialchars(substr($value, 0, strlen($value) - 3), ENT_QUOTES);
				}else{
					$subDate[$key] = htmlspecialchars($value, ENT_QUOTES);
				}
			}
			array_push($allData, $subDate);
		}
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$allData_json = json_encode($allData);

	// WEEKの取得
	$weekData = [];
	$tmpWeek = date("Y-m-d", strtotime(strval($showWeekPage) . " week"));
	$weekArray = getWeekStartAndEndDate($tmpWeek);
	$weekStart = $weekArray["startDate"] . " 00:00:00";
	$weekFinish = $weekArray["finishDate"] . " 23:59:59";
	try{
		$sql = <<<EOS
			SELECT * FROM schedule
			WHERE username = :username
			AND start BETWEEN :weekStart AND :weekFinish
			ORDER BY start ASC
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
		$stmh->bindValue(":weekStart", $weekStart, PDO::PARAM_STR);
		$stmh->bindValue(":weekFinish", $weekFinish, PDO::PARAM_STR);
		$stmh->execute();

		while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
			$subDate = [];
			foreach($row as $key => $value){
				if ($key == "start" || $key == "finish"){
					$subDate[$key] = htmlspecialchars(substr($value, 0, strlen($value) - 3), ENT_QUOTES);
				}else{
					$subDate[$key] = htmlspecialchars($value, ENT_QUOTES);
				}
			}
			array_push($weekData, $subDate);
		}
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$weekStart_json = json_encode($weekArray["startDate"]);
	$weekFinish_json = json_encode($weekArray["finishDate"]);
	$weekData_json = json_encode($weekData);

	// MONTHの取得
	$monthData = [];
	$monthStart = date("Y-m-01", strtotime(strval($showMonthPage) . " month")) . " 00:00:00";
	$monthFinish = date("Y-m-t", strtotime(strval($showMonthPage) . " month")) . " 23:59:59";

	try{
		$sql = <<<EOS
			SELECT * FROM schedule
			WHERE username = :username
			AND start BETWEEN :monthStart AND :monthFinish
			ORDER BY start ASC
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
		$stmh->bindValue(":monthStart", $monthStart, PDO::PARAM_STR);
		$stmh->bindValue(":monthFinish", $monthFinish, PDO::PARAM_STR);
		$stmh->execute();

		while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
			$subDate = [];
			foreach($row as $key => $value){
				if ($key == "start" || $key == "finish"){
					$subDate[$key] = htmlspecialchars(substr($value, 0, strlen($value) - 3), ENT_QUOTES);
				}else{
					$subDate[$key] = htmlspecialchars($value, ENT_QUOTES);
				}
			}
			array_push($monthData, $subDate);
		}
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMessage();
	}

	$monthStart_json = json_encode(date("Y-m-01", strtotime(strval($showMonthPage) . " month")));
	$monthFinish_json = json_encode(date("Y-m-t", strtotime(strval($showMonthPage) . " month")));
	$monthData_json = json_encode($monthData);

?>