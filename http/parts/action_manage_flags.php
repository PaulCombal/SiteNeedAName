<?php
	/*
		Manages flags
			This file is a WIP. Many functions ARE broken or missing.
			Adds / removes / toggles flags for a specified file.
		
		INPUT
			POST variables:
				action (string, mandatory):
					The flag to toggle. Possible values are:
						* 'like' (Positive user feedback)
						* 'dislike' (Negative user feedback)
						* 'moderated' (File manually reviewed as conform by a moderator)
						* 'banned' (File manually reviewed as against the TOS, or bad file)

		OUTPUT
			returns a JSON formatted answer as follows:
				print (boolean, mandatory):
					if true, the "content" property will be used by the client script to be printed on the HTML page

				noCallback (boolean, optionnal):
					On success, a callback function is called. If set to yes, this function should not be called.
					Usually used when there was no erorr handling the request, but it could not be performed because 
					of a bad user action.

				content (string, optionnal)
					The text to be printed on the page, or logged in the JS console. (see 'print')

				error (boolean, optionnal)
					If set to true, the callback will not be called, a generic error will be shown to the user, and content will
					be logged in the JS console. Usually used when a technical issue occurred.
	*/


	session_start();

	/* Validate data received from client */
	if (!isset($_SESSION["userid"]) OR empty($_SESSION["userid"])) {
		die(
			json_encode(
				[
					"print" => true,
					"noCallback" => true,
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
					"error" => true,
					"content" => "[Erreur 0] Entrée incorrecte."
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
			$db -> query("CALL toggleFlag('LIKE', " . $user_id . ", " . $file_id . ");");
			
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
			$db -> query("CALL toggleFlag('DISLIKE', " . $user_id . ", " . $file_id . ");");
			
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