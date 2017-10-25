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
	$global_arr = [];

	try {
		if (is_numeric($_GET['id'])) {
			$file_id = $_GET['id'];
		}
		else {
			throw new Exception("[Erreur 1] Requête incorrecte", 1);
		}


		//getFileByID is a Stored Procedure
		#boarf, no need to quote or htmlspecialchar here, it passed the isnumeric test, right?
		$prettySQL = "CALL getFileByID(" . $file_id . ");";
		try {
			$result = $db -> select($prettySQL);
		} catch (Exception $e) {
			die("Error: " . $e->getMessage());
		}

		if (count($result) <> 1) {
			throw new Exception("[Erreur 2] Incohérence de données", 1);
		}

		$global_arr = $result[0];
	}
	catch(Exception $e)	{
		die("Une erreur est survenue lors de la récupération des informations fichier :( <br>" . $e->getMessage());
	}

	print_r($global_arr);
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
	<!-- crumbread TODO voir ex bootstrap-->
	<div>
		<?php
			echo $global_arr["category"];
			echo " > ";
			echo $global_arr["subcategory"];
			echo " > ";
			echo $global_arr["file_title"];
		?>
	</div>

	<div id="fileWrapper">
		<div id="titleWrapper">
			<div class="sm-6-col">
				<h1 id="fileTitle"><?php echo $global_arr["file_title"];?></h1>
			</div>
			<div class="sm-6-col">
				<div id="submitter"><a href="../../users/<?php echo $global_arr["user_name"]; ?>">Soumis par <?php echo $global_arr["user_name"]; ?></a>
				</div>
				<div id="uploadDate">
					<em>Référencé le <?php echo $global_arr["file_upload_date"]; ?></em>
				</div>
			</div>
		</div>
		<br />
		<!-- If a shortdesc is specified -->

		<div id="shortDesc">
			<?php if (empty($global_arr["file_short_description"])) {
				?>
				<div class="noDescription">
					Aucune desciption courte n'est disponible. <a href="#">Aidez moi je vous en supplie</a>
				</div>
				<?php
			}
			else{
				?>
				<div class="description">Description courte</div>
				<br />
				<?php
				echo $global_arr["file_short_description"];
			}
			?>
		</div>
		
		<!-- If a long description is specified -->
		<div id="longDesc">
			<?php if (empty($global_arr["file_long_description"])) {
				?>
				<div class="noDescription">
					Aucune desciption n'est disponible. <a href="#">Aidez moi je vous en supplie</a>
				</div>
				<?php
			}
			else{
				?>
				<div class="description">Description</div>
				<br />
				<?php
				echo $global_arr["file_long_description"];
			}
			?>
		</div>

		<!-- Links and stats -->
		<div id="linksDiv">
			<h3>Liens et statistiques</h3>
			<div id="hash">
				<div class="description">Hash</div>
				<br />
				<?php
				echo $global_arr["file_hash"]; 
				?>
			</div>

			<!-- TODO -->
		</div>
	</div>
</body>
</html>