<?php

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

	// Arrays containing indexes for both long and short descriptions
	$aLDescsI = [];
	$aSDescsI = [];

	foreach ($aDescs as $key => $value) {
		if ($value["desctype"] === "short") {
			array_push($aSDescsI, $key);
		}
		else {
			array_push($aLDescsI, $key);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Améliorer IPFS France</title>
	<?php include "parts/general_head_includes.php"; ?>
</head>
<body>
	<?php include "parts/header.php"; ?>
	<div class="container">
		<ul class="nav nav-pills">
			<li <?php echo $_GET["length"] === "s" ? 'class="active"' : ''; ?>>
				<a href="#1b" data-toggle="tab">Descriptions courtes</a>
			</li>
			<li <?php echo $_GET["length"] === "l" ? 'class="active"' : ''; ?>>
				<a href="#2b" data-toggle="tab">Descriptions longues</a>
			</li>
		</ul>

		<div class="tab-content clearfix">
			<div class="tab-pane active" id="1b">
				<div class="row">
					<h3>
						Descriptions courtes proposées:				
					</h3>
				</div>
				
				<?php
					foreach ($aSDescsI as &$desc) {
						echo "<div class=\"row\">";
						echo $aDescs[$desc]["description"];
						echo " par ";
						echo $aDescs[$desc]["username"];
						echo " le ";
						echo $aDescs[$desc]["date_last_modified"];
						echo "</div>";
					}
				?>

				<div class="row">
					<h3>
						Proposer une description courte
					</h3>
					<form>
						<label>Champs du formulaire</label>
					</form>
				</div>
			</div>
			<div class="tab-pane" id="2b">
				<div class="row">
					<h3>
						Descriptions longues proposées:				
					</h3>
				</div>
				
				<?php
					foreach ($aLDescsI as &$desc) {
						echo "<div class=\"row\">";
						print_r($aDescs[$desc]);
						echo "</div>";
					}
				?>

				<div class="row">
					<h3>
						Proposer une description longue
					</h3>
					<form>
						<label>Champs du formulaire</label>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Theses ones seem to work usual ones don't correctly -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>