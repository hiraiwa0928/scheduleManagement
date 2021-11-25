<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	require_once "./dbConnect.php";
	$pdo = db_connect();

	$username = $_SESSION["username"];
	$startDate = $_POST["startDate"];
	$startTime = $_POST["startTime"];
	$finishDate = $_POST["finishDate"];
	$finishTime = $_POST["finishTime"];
	$place = htmlspecialchars($_POST["place"], ENT_QUOTES);
	$contents = htmlspecialchars($_POST["contents"], ENT_QUOTES);

	$start = $startDate . " " . $startTime;
	$finish = $finishDate . " " . $finishTime;
?>