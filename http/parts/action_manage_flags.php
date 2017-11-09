<?php
	if (!isset($_POST["action"]) OR empty($_POST["action"]) OR
		!isset($_SESSION["userid"]) OR empty($_SESSION["userid"]) OR
		!isset($_POST["fileid"]) OR empty($_POST["fileid"])) {
		die("[Erreur 0] Entrée incorrecte");
	}

	die("OK je suis dans la matrice");

	include_once "../libs/database.php";
	$db = New Db();

	$user_id = $db -> quote ($_SESSION["userid"]);
	$file_id = $db -> quote ($_POST["fileid"]);

	// We use the applyFlags procedure
	switch ($_POST["action"]) {
		case 'like':
			# code...
			break;
		
		default:
			die("[Error 1] Action inconnue");
			break;
	}
?>