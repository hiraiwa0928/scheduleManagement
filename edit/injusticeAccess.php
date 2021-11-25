<?php
	session_start();
	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>編集画面</title>
	<link rel="stylesheet" type="text/css" href="../stylesheet.css">
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
	<hr>
	<div class="enclosure" style="width: 60%">
		不正なアクセスです<br><br>
		<a href='../main/schedule.php'>Schedule</a>
	</div>
</body>
</html>