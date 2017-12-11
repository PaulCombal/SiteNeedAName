<?php
	include_once "libs/urlify.php";

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
	<!-- Custom CSS for the search page -->
	<link rel="stylesheet" href="css/custom_search.css" />

	<!-- Custom scripts (clipboard + hover) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
	<script src="./js/searchPage.js"></script>
</head>
<body>

<?php

	include "./parts/header.php";

	?>
	<div class="container">
	
	<?php
		#TODO Review procedure to only return required fields
		#with a correct name
		$result = $db -> select ("CALL getPostsBySearch(" . $db -> quote($_GET["search"]) . ", NULL, NULL, NULL, NULL);");
		if (count($result) === 0) {
			die("<em>Aucun résultat trouvé.. Vous aurez peut-être plus de chance avec expression plus courte.</em>");
		}

		foreach ($result as &$row) {
			echo '<div class="row">';
			#print_r($row);
			echo '<a class="result-mainLink" href="./télécharger/' . $row['file_id'] . '/' . urlify($row['file_title']) . '">' . $row['file_title'] . '</a>';
			
			echo '<span class="shortcutIcons">';
			echo '<a href="#"><span title="Copier le hash" class="glyphicon glyphicon-copy" data-clipboard-text="' . $row['file_hash'] . '"></span></a> ';
			echo '<a href="#"><span title="Télécharge en navigateur. IPFS doit être lancé sur votre ordinateur." class="glyphicon glyphicon-cloud-download"></span></a> ';
			echo '<a href="#"><span title="Télécharger par le mirroir ipfs.io" class="glyphicon glyphicon-save-file"></span></a> ';
			echo '<a href="#">TODO flags</a>';
			echo '</span>';

			echo "<br />";
			echo '<div class="result-breadcrumb">' . $row["file_breadcrumb"] . '</div>';
			echo '<div class="result-description">' . $row["file_description"] . '</div>';

			echo "</div>";
		}


		ob_end_flush();
	?>
	</div>

</body>
</html>