<?php
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Paris');

	/**
	 * Starts the submit process.
	 * Post data HAS to be valid at this point
	 *
	 */
	function submit() {
		$db = new Db();

		// Directly related to the database. Do not change unless you
		//Also modify the database length
		define('MAX_TITLE_LENGTH', 60);
		define('MAX_DESCRIPTION_LENGTH', 60);
		define('MAX_LONGDESCRIPTION_LENGTH', 5000);
		define('MAX_HASH_LENGTH', 100);
		define('MAX_HTTPMIRROR_LENGTH', 255);
		define('GENERIC_ERROR_MESSAGE', '<script>$("#errorDiv").removeAttr("style");</script>');
		
		# Required values
		$title = $db -> quote(htmlspecialchars($_POST['title']));
		$ipfs_hash = $db -> quote(htmlspecialchars($_POST['ipfs_hash']));
		$category_id = $db -> quote(htmlspecialchars($_POST['cat']));
		$subcatgeroy_id = $db -> quote(htmlspecialchars($_POST['subcat']));

		# Optional values
		$http_mirror = (isset($_POST['http_mirror']) AND !empty($_POST['http_mirror'])) ? $db -> quote(htmlspecialchars($_POST['http_mirror'])) : "NULL";
		
		$short_desc = (isset($_POST['short_desc']) AND !empty($_POST['short_desc'])) ? $db -> quote(htmlspecialchars($_POST['short_desc'])) : "NULL";

		$long_desc = (isset($_POST['long_desc']) AND !empty($_POST['long_desc'])) ? $db -> quote(htmlspecialchars($_POST['long_desc'])) : "NULL";

		#Users accessing this page must be logged
		$mySafeUserID = $_SESSION["userid"];
		#There shouldn't be any issue with session vars, but here goes nothing
		if(!is_numeric($mySafeUserID))
			die("Something fucked up bad");
		
		if (smaller_length($title, MAX_TITLE_LENGTH) And 
			smaller_length($ipfs_hash, MAX_HASH_LENGTH) And
			smaller_length($http_mirror, MAX_HTTPMIRROR_LENGTH) And
			smaller_length($short_desc, MAX_DESCRIPTION_LENGTH) And
			smaller_length($long_desc, MAX_LONGDESCRIPTION_LENGTH)
			) {
			#All lengths Are correct
		}
		else{
			die(GENERIC_ERROR_MESSAGE);
		}

		#TODO regex checks on hash / http mirror

		#If the below code is executed, this means the post data is well formatted
		$prettySQL = "INSERT INTO `files` (`category_id`, `subcategory_id`, `title`, `description`, `longdescription`, `uploaddate`, `hash`, `httpmirror`, `user_id`) VALUES(" . $category_id . ", " . $subcatgeroy_id . ", " . $title . ", " . $short_desc . ", " . $long_desc . ", NOW(), " . $ipfs_hash . ", " . $http_mirror . ", " . $mySafeUserID . ");";

		#echo $prettySQL;
		
		$db -> query($prettySQL);
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

?>