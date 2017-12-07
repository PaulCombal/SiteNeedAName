<?php
	# This file is included from the submit page. No need to specify path from parent folder
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Paris');

	/**
	 * Starts the submit process.
	 * Post data HAS to be valid at this point
	 * TODO : Use show_error_message more often instead of generic error
	 */
	function submit() {
		$db = new Db();

		// Directly related to the database. Do not change unless you
		// also modify the database data types
		define('MAX_TITLE_LENGTH', 60);
		define('MAX_DESCRIPTION_LENGTH', 60);
		define('MAX_LONGDESCRIPTION_LENGTH', 5000);
		define('MAX_HASH_LENGTH', 100);
		define('MAX_HTTPMIRROR_LENGTH', 255);
		define('SHOW_DEFAULT_ERROR_MESSAGE', '<script>$("#errorDiv").removeAttr("style");</script>');
		define('IPFS_IPNS_REGEX_VALIDATOR', '/^\/ipfs\/Qm[1-9A-HJ-NP-Za-km-z]{44}(\/.*)?|^\/ipns\/.+/');
		
		# Required values
		$title = $db -> quote(htmlspecialchars($_POST['title']));
		$ipfs_hash = $db -> quote(htmlspecialchars($_POST['ipfs_hash']));
		$category_id = $db -> quote(htmlspecialchars($_POST['cat']));
		$subcatgeroy_id = $db -> quote(htmlspecialchars($_POST['subcat']));

		# Optional values (SQL values to be put in the query)
		$http_mirror = (isset($_POST['http_mirror']) AND !empty($_POST['http_mirror'])) ? $db -> quote(htmlspecialchars($_POST['http_mirror'])) : "NULL";
		$short_desc = (isset($_POST['short_desc']) AND !empty($_POST['short_desc'])) ? $db -> quote(htmlspecialchars($_POST['short_desc'])) : "NULL";
		$long_desc = (isset($_POST['long_desc']) AND !empty($_POST['long_desc'])) ? $db -> quote(htmlspecialchars($_POST['long_desc'])) : "NULL";

		# Users accessing this page must be logged
		# There shouldn't be any issue with session vars, but here goes nothing
		$mySafeUserID = $_SESSION["userid"];
		if(!is_numeric($mySafeUserID))
			die("Something fucked up bad");

		# We make sure the data length is correct	
		if (smaller_length($title, MAX_TITLE_LENGTH) And 
			smaller_length($ipfs_hash, MAX_HASH_LENGTH) And
			smaller_length($http_mirror, MAX_HTTPMIRROR_LENGTH) And
			smaller_length($short_desc, MAX_DESCRIPTION_LENGTH) And
			smaller_length($long_desc, MAX_LONGDESCRIPTION_LENGTH)
			) {
			#All lengths Are correct
		}
		else{
			#default error message is: something went bad, please report to github
			die(SHOW_DEFAULT_ERROR_MESSAGE);
		}

		# Regex checks on hash / http mirror
		# We're not using our $ipfs_hash variable, because it's quoted
		if (preg_match(IPFS_IPNS_REGEX_VALIDATOR, $_POST['ipfs_hash']) !== 1) {
			# There are 0 matches, given hash is not a ipfs hash, or an error occurred.
			# If incorrect please open an issue or make a pull request.

			die(SHOW_DEFAULT_ERROR_MESSAGE);
		}

		if ($http_mirror !== "NULL" AND !filter_var($_POST['http_mirror'], FILTER_VALIDATE_URL)) {
			# An HTTP mirror is specified, but does not pass validation
			die(SHOW_DEFAULT_ERROR_MESSAGE);
		}


		$prettySQL = "CALL insertNewFile(" . $category_id . ", " . $subcatgeroy_id . ", " . $title . ", " . $short_desc . ", " . $long_desc . ", " . $ipfs_hash . ", " . $http_mirror . ", " . $mySafeUserID . ");";

		#echo $prettySQL;

		$result = $db -> select($prettySQL);
		if($result === false)
			die(showErrorMessage($db -> error()));

		$file_id = $result[0]['file_id'];
		
		#'Headers already sent by' may occur
		#header("Location: ../../index.php");
		echo "<script>window.location.replace(window.location.origin + '/télécharger/' + " . $file_id . " + '/' + '" . str_replace(" ", "-", $_POST['title']) . "')</script>";
	}

	/**
	 * Checks if the given string is shorter than specified. Useful to check
	 * if a value can fit in a database entry.
	 *
	 * @param string value to evaluate.
	 * @param integer max length.
	 * @return boolean.
	 */
	function smaller_length($value, $length) {
		# If an optional field has not been filled, pass the check anyway
		if($value === "NULL")
			return true;
		else
			return is_string($value) and strlen($value) <= $length + 2; //+2 => mind the quotes
	}

	/**
	* Displays the SQL error (for now), and translates it to a human-readable 
	* error message
	*
	* @param message
	*  The SQL error message
	* 
	* @return
	*  Nothing
	*/
	function showErrorMessage($message) {
		#Make sure to check the database constraint names before changing anything
		switch (true) {
			case strstr($message, 'title_UNIQUE'):
				$errorMessage = "Un autre fichier possède déjà ce titre, veuillez vérifier que le fichier à référencer ne le soit pas déjà.";
				break;

			case strstr($message, 'hash_UNIQUE'):
				$errorMessage = "Le hash que vous avez entré est déjà référencé.";
				break;
			
			default:
				$errorMessage = "Une erreur inconnue s'est produite, veuillez informer les développeurs de ce problème. Message d'erreur: " . $message;
				break;
		}

		#We empty the error div, and set the new error message in it
		echo '<script>$("#errorDiv").removeAttr("style").empty().append("' . $errorMessage . '");</script>';
	}

?>