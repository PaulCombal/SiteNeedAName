<?php
	//Start the output buffer
	ob_start();
	
	//Start the session
	if(!isset($_SESSION)) {
		session_start();
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
</head>
<body>

<?php

	include "./parts/header.php";
	include "./parts/index_search.php";

	ob_end_flush();
?>

</body>
</html>