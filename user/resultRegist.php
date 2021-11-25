<?php
	session_start();
	if (isset($_SESSION["username"])){
		header("Location: ../main/schedule.php");
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>新規登録画面</title>
	<link rel="stylesheet" type="text/css" href="../stylesheet.css">
	<script>
		function judgeResult(){
			var resultArea = document.getElementById("resultArea");
			var query = window.location.href.split("?")[1];
			if (query == null){
				resultArea.innerHTML = "不正なアクセスです<br><br><a href='./inputUser.php'>Sign in</a>";
			}else{
				var param = query.split("=")[1];

				if (param == "true"){
					resultArea.innerHTML = "登録に成功しました<br><br><a href='../index.php'>Sign in</a>";
				}else if(param == "false"){
					resultArea.innerHTML = "登録に失敗しました<br><br><a href='./inputUser.php'>Sign up</a>";
				}else{
					resultArea.innerHTML = "不正なアクセスです<br><br><a href='../inputUser.php'>Sign in</a>";
				}
			}
		}
		window.onload = function(){
			judgeResult();
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
		</div>
	</header>
	<div class="enclosure" style="width: 60%">
		<div class="title">RESULT</div><br>
		<div id="resultArea">

		</div>
	</div>
</body>
</html>