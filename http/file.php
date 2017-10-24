<?php
	//Start the session
	if(!isset($_SESSION)) {
		session_start();
	}

	//include plugins and database lib
	include "./parts/includes.php";

	//Create a database interface
	//On failure, displays a nice error message and nothing else.
	$db = new Db();
	try {
		$db->connect();
	}
	catch(Exception $e)	{
		die("An error occurred connecting to the database: " . $e->getMessage());
	}

	//Globals
	$file_id = 0;
	$global_arr = [
		"submitter_name" => "",
		"submitter_id" => "",
		"subcategory" => "",
		"upload_date" => "",
		"http_mirror" => "",
		"short_desc" => "",
		"long_desc" => "",
		"category" => "",
		"title" => "",
		"hash" => ""
	];

	try {
		if (is_numeric($_GET['id'])) {
			$file_id = $_GET['id'];
		}
		else {
			throw new Exception("[Erreur 1] Requête incorrecte", 1);
		}

		/*
		getFileByID Stored Procedure:
		SELECT 
		users.id As `user_id`, 
		users.username as `user_name`, 
		files.title as `file_title`,
		categories.name as `category`,
		subcategories.name as `subcategory`,
		files.uploaddate as `file_upload_date`,
		files.description as `file_short_description`, 
		files.longdescription as `file_long_description`,
		files.hash as `file_hash`,
		files.httpmirror as `file_http_mirror`
		FROM files 
		INNER JOIN users ON user_id = users.id
		INNER JOIN categories ON category_id = categories.id
		INNER JOIN subcategories ON subcategory_id = subcategories.id AND subcategories.category_id = categories.id;
		*/
		#boarf, no need to quote or htmlspecialchar here, it passed the isnumeric test, right?
		$prettySQL = "CALL PROCEDURE getFileInfoByID(" . $file_id . ");";
		#$result = $db -> query($prettySQL);
	}
	catch(Exception $e)	{
		die("Une erreur est survenue lors de la récupération des infos fichier :( <br>" . $e->getMessage());
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>MONSITE</title>
	<?php include "parts/general_head_includes.php"; ?>
</head>
<body>

	<?php
		include "./parts/header.php";
	?>
	<div id="fileWrapper">
		<h1 id="fileTitle"><?php ?></h1>
		<br />
		<!-- If a shortdesc is specified -->

		<!-- If a long description is specified -->

		<!-- Links and stats -->
	</div>
</body>
</html>