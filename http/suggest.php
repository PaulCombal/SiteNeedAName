<?php
	//ob_start();
	session_start();

    // Include plugin.
    //include_once "../../plugins/private_signup_plugin.php";

    // Redirect if the user not logged in.
	if(!isset($_SESSION["username"])) {
	    header("Location: ./../../../register.php");
	    exit;
	}

	$iFile_id = 0;
	$bShortdesc = false;

	if (isset($_GET['file_id']) AND !empty($_GET['file_id']) AND is_numeric($_GET['file_id'])) {
		$iFile_id = $_GET['file_id'];
	}
	else {
		print_r($_GET);
		die("ERROR #1: Unable to retrieve a correct file identifier.");
	}

	if (isset($_GET['short'])) {
		$bShortdesc = true;
	}

	include_once "libs/database.php";
	$db = new Db();

	// We now have to retrieve all the required data
	$aDescs = $db -> select("CALL getPendingDescriptions(" . $iFile_id . ");");

	if($aDescs === false) {
		die("ERROR #2: Impossible to retrieve pending descriptions.");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Suggérer une description courte</title>

	<!-- Necessary scripts for jQuery and Bootstrap -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<!-- CSS -->
	<?php include "parts/general_head_includes.php"; ?>
</head>
<body>
	<?php include "parts/header.php"; ?>
	<div class="container">
		Je dois afficher les description pour le fichier numéro <?php echo $iFile_id; ?>
	</div>
	<?php
		foreach ($desc as &$aDescs) {
			echo "<div class=\"row\">";
			echo "string";
			echo "</div>"
		}
	?>
</body>
</html>