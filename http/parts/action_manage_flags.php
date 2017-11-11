<?php
	session_start();
	
	/* Validate data received from client */
	if (!isset($_SESSION["userid"]) OR empty($_SESSION["userid"])) {
		die(
			json_encode(
				[
					"print" => true,
					"content" => '<script>alert("Vous devez d\'abord vous connecter pour voter.");</script>'
				]
			)
		);
	}

	if (!isset($_POST["action"]) OR empty($_POST["action"]) OR
		!isset($_POST["fileid"]) OR empty($_POST["fileid"])) {
		die(
			json_encode(
				[
					"print" => false,
					"content" => "[Erreur 0] Entrée incorrecte"
				]
			)
		);
	}

	/* Connect to the database and escape data */
	include_once "../libs/database.php";
	$db = New Db();

	$user_id = $db -> quote ($_SESSION["userid"]);
	$file_id = $db -> quote ($_POST["fileid"]);

	// We use the applyFlag procedure
	switch ($_POST["action"]) {
		case 'like':
			$db -> query("CALL applyFlag('LIKE', " . $user_id . ", " . $file_id . ");");
			break;
		
		default:
			die("[Error 1] Action inconnue");
			break;
	}
?>