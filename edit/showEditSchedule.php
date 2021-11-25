<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	require_once "../processing/checkEditSchedule.php";

	try{
		$id = (int)$_GET["id"];
	}catch(Exception $e){
		header("Location: ../edit/injusticeAccess.php");
	}

	// GETで取得したidのスケジュールを取得
	require_once "../processing/dbConnect.php";
	$pdo = db_connect();

	$scheduleData = array();

	try{
		$sql = <<<EOS
			SELECT * FROM schedule
			WHERE id = :id
		EOS;
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(":id", $id, PDO::PARAM_INT);
		$stmh->execute();

		foreach($stmh->fetch() as $key => $value){
			if ($key == "start"){
				$scheduleData["start"] = htmlspecialchars(substr($value, 0, strlen($value) - 3), ENT_QUOTES);
				$scheduleData["startDate"] = explode(" ", $value)[0];
				$scheduleData["startTime"] = explode(" ", $value)[1];
			}else if($key == "finish"){
				$scheduleData["finish"] = htmlspecialchars(substr($value, 0, strlen($value) - 3), ENT_QUOTES);
				$scheduleData["finishDate"] = explode(" ", $value)[0];
				$scheduleData["finishTime"] = explode(" ", $value)[1];
			}else{
				$scheduleData[$key] = htmlspecialchars($value, ENT_QUOTES);
			}
		}
	}catch(PDOException $Exception){
		print "エラー:".$Exception->getMEssage();
	}

	$dispData = $scheduleData;

	if (isset($_SESSION["timeError"]) && $_SESSION["timeError"] == true){
		$timeError = $_SESSION["timeError"];
		$timeError_json = json_encode($timeError);

		$dispData["place"] = htmlspecialchars($_SESSION["place"], ENT_QUOTES);
		$dispData["contents"] = htmlspecialchars($_SESSION["contents"], ENT_QUOTES);
		$dispData["startDate"] = null;
		$dispData["startTime"] = null;
		$dispData["finishDate"] = null;
		$dispData["finishTime"] = null;
	}

	unset($_SESSION["timeError"]);
	unset($_SESSION["place"]);
	unset($_SESSION["contents"]);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>編集画面</title>
	<link rel="stylesheet" type="text/css" href="../stylesheet.css">
	<script>
		function initProcess(){

			// スケジュール登録の時間に不正があった場合
			if (JSON.parse('<?php echo $timeError_json?>') == true){
				var msgArea = document.getElementById("msgArea");
          msgArea.innerHTML = "<font color='red'>時間の入力が不正です</font><br>";
			}
		}
		window.onload = function(){
			initProcess();
		}
	</script>
</head>
<body>
	<header>
    <div class="header-inner">
			<h1 class="header-logo">
				<img class="header-logoImg" src="../image/logo.png">
				<span class="header-logoTtl">My Schedule</span>
			</h1>
			<nav class="header-nav">
				<ul class="header-navList">
					<li>
							<a href="../main/schedule.php">Schedule</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="enclosure" style="width: 60%">
		<div class="title">EDIT</div><br>
			<form method="post" action="../processing/editSchedule.php">
				開始日時: <input type="date" id="startDate" name="startDate" value="<?=$dispData["startDate"]?>" required> 
				<input type="time" id="startTime" name="startTime" value="<?=$dispData["startTime"]?>" required><br><br>
				終了日時: <input type="date" id="finishDate" name="finishDate" value="<?=$dispData["finishDate"]?>" required>
				<input type="time" id="finishTime" name="finishTime" value="<?=$dispData["finishTime"]?>" required><br>
				<span id="msgArea">

				</span><br>
				内容: <input type="text" id="contents" name="contents" minlength=1 maxlength=30 value="<?=$dispData["contents"]?>" required><br><br>
				場所: <input type="text" id="place" name="place" minlength=1 maxlength=30 value="<?=$dispData["place"]?>" required><br><br>
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="submit" value="編 集">
			</form>
		</div>
	</body>
	<div class="enclosure" style="width: 60%">
		<div class="title">DELETE</div><br>
		下記のスケジュールを削除します<br>
		<table>
			<tr>
				<th>開始日時</th>
				<th>終了日時</th>
				<th>内容</th>
				<th>場所</th>
			</tr>
			<tr>
				<td><?=$scheduleData["start"]?></td>
				<td><?=$scheduleData["finish"]?></td>
				<td><?=$scheduleData["contents"]?></td>
				<td><?=$scheduleData["place"]?></td>
			</tr>
		</table>
		<form method="post" action="../processing/deleteSchedule.php">
			<input type="hidden" name="id" value="<?=$id?>"><br>
			<input type="submit" value="削 除">
		</form>
	</div>
</html>