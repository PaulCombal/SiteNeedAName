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

	switch ($_POST["action"]) {
		case 'like':
			$db -> query("CALL applyFlag('LIKE', " . $user_id . ", " . $file_id . ");");
			
			die(
				json_encode(
					[
						"print" => false,
						"content" => "File like request acknowledged."
					]
				)
			);
			break;

		case 'dislike':
			$db -> query("CALL applyFlag('DISLIKE', " . $user_id . ", " . $file_id . ");");
			
			die(
				json_encode(
					[
						"print" => false,
						"content" => "File dislike request acknowledged."
					]
				)
			);
			break;
		
		default:
			die(
				json_encode(
					[
						"print" => false,
						"error" => true,
						"content" => "Unrecognized action."
					]
				)
			);
			break;
	}
?>