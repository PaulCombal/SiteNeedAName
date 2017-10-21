<?php
	//Start the output buffer
	ob_start();
	
	//Start the session
	if(!isset($_SESSION)) {
		session_start();
	}

	//If user clicked "search" without any text input
	if (!isset($_GET["search"]) or empty($_GET["search"])) {
		header("Location: ./index.php");
	}

	//include plugins and database lib
	include "./parts/includes.php";

	//Create a database interface
	//On failure, displays a nice error message and nothing else.
	$db = new Db();
	try
	{
		$db->connect();
	}
	catch(Exception $e)
	{
		ob_clean();
		die("An error occurred connecting to the database: " . $e->getMessage());
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MONSITE</title>
	<?php include "parts/general_head_includes.php"; ?>
	<link rel="stylesheet" href="css/custom_search.css" />
</head>
<body>

<?php

	include "./parts/header.php";
	


	ob_end_flush();
?>

</body>
</html>