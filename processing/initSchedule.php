<?php
	session_start();

	if (!isset($_SESSION["username"])){
		header("Location: ../index.php");
	}

	$display = null;
	if (isset($_GET["display"])){
		$display = $_GET["display"];
	}
	$display_json = json_encode($display);

	$timeError = null;
	if (isset($_SESSION["timeError"])){
		$timeError = $_SESSION["timeError"];
		unset($_SESSION["timeError"]);
	}
	$timeError_json = json_encode($timeError);

	$success = null;
	if (isset($_SESSION["success"])){
		$success = $_SESSION["success"];
		unset($_SESSION["success"]);
	}
	$success_json = json_encode($success);

	$edit = null;
	if (isset($_SESSION['edit'])){
		$edit = $_SESSION["edit"];
		unset($_SESSION["edit"]);
	}
	$edit_json = json_encode($edit);

	$delete = null;
	if (isset($_SESSION["delete"])){
		$delete = $_SESSION["delete"];
		unset($_SESSION["delete"]);
	}
	$delete_json = json_encode($delete);
?>