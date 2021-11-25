<?php
	session_start();
	if (isset($_SESSION["username"])){
		header("Location: ./main/schedule.php");
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン画面</title>
	<link rel="stylesheet" type="text/css" href="./stylesheet.css">
</head>
<body>
	<header>
    <div class="header-inner">
			<h1 class="header-logo">
				<img class="header-logoImg" src="./image/logo.png">
				<span class="header-logoTtl">My Schedule</span>
			</h1>
			<nav class="header-nav">
				<ul class="header-navList">
					<li>
							<a href="./user/inputUser.php">Sign up</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="enclosure" style="width: 60%">
	<div class="title">SIGN IN</div><br>
		<form method="post" action="./processing/login.php">
			ユーザー名: <input name="username" type="text" minlength=3 maxlength=20 value="<?=$_GET['username']?>" required><br><br>
			パスワード: <input name="password" type="password" minlength=8 maxlength=128 required><br>
			<?php
				if (isset($_GET['username'])){
					print "<font color='red'>ユーザー名またはパスワードが間違っています</font><br>";
				}
			?>
			<br>
			<input type="submit" value="ログイン">
		</form>
		<br>
	</div>
</body>
</html>