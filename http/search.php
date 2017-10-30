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
	<title><?php echo $_GET["search"]; ?> - Recherche Monsite</title>
	<?php include "parts/general_head_includes.php"; ?>
	<link rel="stylesheet" href="css/custom_search.css" />
	<script src="./js/searchPage.js"></script>
</head>
<body>

<?php

	include "./parts/header.php";

	?>
	<div class="container">
	
	<?php

		$result = $db -> select ("CALL getPostsBySearch(" . $db -> quote($_GET["search"]) . ", NULL, NULL, NULL, NULL);");
		if (count($result) === 0) {
			die("<em>Aucun résultat trouvé.. Vous aurez peut-être plus de chance avec expression plus courte.</em>");
		}

		foreach ($result as &$row) {
			echo '<div class="row">';
			#print_r($row);
			echo '<a class="searchResultRow" href="./télécharger/' . $row['id'] . '/' . str_replace(" ", "-", $row['title']) . '">' . $row['title'] . '</a>';
			
			echo '<span class="shortcutIcons">';
			echo '<a href="#"><span title="Copier le hash" class="glyphicon glyphicon-copy"></span></a>   ';
			echo '<a href="#"><span title="TODOD" class="glyphicon glyphicon-cloud-download"></span></a>                ';
			echo '<a href="#"><span title="TODODO" class="glyphicon glyphicon-save-file"></span></a>      ';
			echo '<a href="#">TODO flags</a>';
			echo '</span>';

			echo "<br />";
			echo '<div>TODO breadcrumb</div>';
			echo '<div>' . $row["description"];
			echo "</div>";
		}


		ob_end_flush();
	?>
	</div>

</body>
</html>