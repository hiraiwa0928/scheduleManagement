<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	require_once "../processing/getScheduleInfo.php";
	require_once "../processing/initSchedule.php";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>スケジュール画面</title>
	<link rel="stylesheet" type="text/css" href="../stylesheet.css">
	<script>

		var display = "ALL";

		function showAll(){
			display = "ALL";
			document.getElementById("display").value = "ALL";
			document.getElementById("all").className = "active";
			document.getElementById("week").className = "passive";
			document.getElementById("month").className = "passive";
		}

		function showWeek(){
			display = "WEEK";
			document.getElementById("display").value = "WEEK";
			document.getElementById("all").className = "passive";
			document.getElementById("week").className = "active";
			document.getElementById("month").className = "passive";
		}

		function showMonth(){
			display = "MONTH";
			document.getElementById("display").value = "MONTH";
			document.getElementById("all").className = "passive";
			document.getElementById("week").className = "passive";
			document.getElementById("month").className = "active";
		}

		function showData(){
			const target = ["allInfo", "weekInfo", "monthInfo"];
			const data = [<?php echo $allData_json; ?>,
										<?php echo $weekData_json; ?>,
										<?php echo $monthData_json; ?>];
			for(var i = 0; i < 3; i++){
				if (data[i].length != 0){
					htmlStr = "<table><tr><th>開始日時</th><th>終了日時</th><th>内容</th><th>場所</th></tr>";
					for(var j = 0; j < data[i].length; j++){
						htmlStr += "<tr class='hover-schedule' onclick=editData(" + data[i][j]["id"] + ")><td>" + data[i][j]["start"] + "</td><td>" + data[i][j]["finish"] + "</td>\
												<td>" + data[i][j]["contents"] + "</td><td>" + data[i][j]["place"] + "</td></tr>"
					}
					htmlStr += "</table>";
				}else{
					htmlStr = "<div style='font-size: 30px; font-weight:bold;'>No Data</div>";
				}
				document.getElementById(target[i]).innerHTML = htmlStr;
			}
		}

		function editData(id){
			window.location.href = "../edit/showEditSchedule.php?id=" + id;
		}

		function changePeriod(command){
			
			var showWeekPage = parseInt(<?php echo $showWeekPage_json?>);
			var showMonthPage = parseInt(<?php echo $showMonthPage_json?>);
			
			if (command == "beforeWeek"){
				showWeekPage -= 1;
			}else if(command == "afterWeek"){
				showWeekPage += 1;
			}else if(command == "beforeMonth"){
				showMonthPage -= 1;
			}else if(command == "afterMonth"){
				showMonthPage += 1;
			}
			
			window.location.href = "./schedule.php?display=" + display +"&showWeekPage=" + String(showWeekPage) + 
															"&showMonthPage=" + String(showMonthPage);
		}

		function initProcess(){

			var display = JSON.parse('<?php echo $display_json; ?>');
			
			// ラジオボタンのcheckを設定
			if (display == "WEEK"){
				showWeek();
				document.getElementById("weekButton").checked = true;
			}else if(display == "MONTH"){
				showMonth();
				document.getElementById("monthButton").checked = true;
			}else{
				showAll();
				document.getElementById("allButton").checked = true;
			}

			// スケジュール登録の時間に不正があった場合
			if (JSON.parse('<?php echo $timeError_json?>') == true){
				var msgArea = document.getElementById("msgArea");
          msgArea.innerHTML = "<font color='red'>時間の入力が不正です</font><br>";
          // 画面を一番下にスクロールする
          var element = document.documentElement;
          var bottom = element.scrollHeight - element.clientHeight;
          window.scroll(0, bottom);
			}

			// スケジュール登録が成功した場合
			if (JSON.parse('<?php echo $success_json?>') == true){
				alert("登録が完了しました");
			}

			// スケジュール変更が成功した場合
			if (JSON.parse('<?php echo $edit_json ?>') == true){
				alert("変更が完了しました");
			}

			// スケジュール削除が成功した場合
			if (JSON.parse('<?php echo $delete_json?>') == true){
				alert("削除が完了しました");
			}

			// weekとmonthの範囲を表示
			var weekStart = JSON.parse('<?php echo $weekStart_json?>');
			var weekFinish = JSON.parse('<?php echo $weekFinish_json?>');
			document.getElementById("weekPeriod").innerHTML = weekStart + "〜" + weekFinish;

			var monthStart = JSON.parse('<?php echo $monthStart_json?>');
			var date = monthStart.split("-");
			document.getElementById("monthPeriod").innerHTML = date[0] + "年" + date[1] + "月";
		}

		window.onload = function(){
			showData();
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
							<a href="../processing/logout.php">Logout</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="enclosure" style="width: 60%;">
		<div class="title">SELECT</div><br>
		<div>
			<input id="allButton" type="radio" name="showRange" onchange="showAll()">ALL
			<input id="weekButton" type="radio" name="showRange" onchange="showWeek()">WEEK
			<input id="monthButton" type="radio" name="showRange" onchange="showMonth()">MONTH
		</div>
	</div>
	<div class="enclosure" style="width: 60%;">
		<!-- すべてのスケジュールを表示 -->
		<div id="all" class="active">
			<div class="title">ALL</div><br>
			<div id="allInfo">

			</div>
		</div>
		<!-- 週ごとのスケジュールを表示 -->
		<div id="week" class="passive">
			<div class="title">WEEK</div><br>
			<button onClick="changePeriod('beforeWeek')">＜＜</button>
			<div id="weekPeriod" style="font-size: 20px; display: inline;"></div>
			<button onClick="changePeriod('afterWeek')">＞＞</button>
			<div id="weekInfo">

			</div>
		</div>
		<!-- 月ごとのスケジュールを表示 -->
		<div id="month" class="passive">
			<div class="title">MONTH</div><br>
			<button onClick="changePeriod('beforeMonth')">＜＜</button>
			<div id="monthPeriod" style="font-size: 20px; display: inline;"></div>
			<button onClick="changePeriod('afterMonth')">＞＞</button>
			<div id="monthInfo">

			</div>
		</div>
	</div>
	<div class="enclosure" style="width: 60%;">
		<div class="title">REGIST</div><br>
		<form method="post" action="../processing/addSchedule.php">
			開始日時: <input type="date" id="startDate" name="startDate" required> <input type="time" id="startTime" name="startTime" required><br><br>
			終了日時: <input type="date" id="finishDate" name="finishDate" required> <input type="time" id="finishTime" name="finishTime" required><br>
			<span id="msgArea">

			</span><br>
			内容: <input type="text" id="contents" name="contents" minlength=1 maxlength=30 value="<?=$_SESSION["contents"]?>" required><br><br>
			場所: <input type="text" id="place" name="place" minlength=1 maxlength=30 value="<?=$_SESSION["place"]?>" required><br><br>
			<input type="hidden" name="showWeekPage" value="<?=$showWeekPage?>">
			<input type="hidden" name="showMonthPage" value="<?=$showMonthPage?>">
			<input type="hidden" id="display" name="display">
			<input type="submit" value="登 録">
		</form>
	</div>
</body>
</html>