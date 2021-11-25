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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		usernameJudge = false;
		passwordJudge = false;

		function judgeExistMember(){
			var username = document.getElementById("username").value;
			var msgArea1 = document.getElementById("msgArea1");
			var registerButton = document.getElementById("registerButton");

			if(username.length >= 3){
				$.ajax({
					type: "post",
					url: "../processing/judgeExistMember.php",
					data:{
						"username": username
					},
					success: function(result){
						console.log(result);
						if (result == true){
							usernameJudge = true;
							msgArea1.innerHTML = "<font color='green'>使用可能なユーザー名です</font><br>";
						}else{
							usernameJudge = false;
							registerButton.disabled = true;
							msgArea1.innerHTML = "<font color='red'>そのユーザー名はすでに使われています</font><br>";
						}
					}
				});
			}else{
				usernameJudge = false;
				registerButton.disabled = true;
				msgArea1.innerHTML = "";
			}

			matchPassword();
		}

		function matchPassword(){
			var password = document.getElementById("password").value;
			var password_confirm = document.getElementById("password_confirm").value;
			var msgArea2 = document.getElementById("msgArea2");
			var registerButton = document.getElementById("registerButton");

			if (password.length < 8 || password_confirm.length < 8){
				passwordJudge = false;
				registerButton.disabled = true;
				msgArea2.innerHTML = "";

				return
			}

			if (password == password_confirm){
				passwordJudge = true;
				msgArea2.innerHTML = "";
			}else{
				passwordJudge = false;
				registerButton.disabled = true;
				msgArea2.innerHTML = "<font color='red'>パスワードが不一致です</font><br>"
			}

			judgeRegisterButton();
		}

		function judgeRegisterButton(){
			var registerButton = document.getElementById("registerButton");

			if (usernameJudge && passwordJudge){
				registerButton.disabled = false;
			}
		}

		setInterval("judgeExistMember()", 1000);
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
							<a href="../index.php">Sign in</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="enclosure" style="width: 60%">
		<div class="title">SIGN UP</div><br>
		<form method="post" action="../processing/addUser.php">
			ユーザー名: <input id="username" name="username" type="text" minlength=3 maxlength=20 required><br>
			<span id="msgArea1">
				
			</span><br>
			パスワード: <input id="password" name="password" type="password" minlength=8 maxlength=128 required><br><br>
			パスワード確認: <input id="password_confirm" name="password_confirm" type="password" minlength=8 maxlength=128 required><br>
			<span id="msgArea2">

			</span><br>
			<input id="registerButton" type="submit" value="登 録" disabled>
		</form>
	</div>
	<br>
	<div class="enclosure">
		※ ユーザー名は3文字以上20文字以下<br>
		※ パスワードは8文字以上128文字以下で設定してください
	</div>
</body>
</html>