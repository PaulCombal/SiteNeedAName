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

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1 id="fileTitle"><?php echo $global_arr["file_title"];?></h1>
			</div>
			<!--<div class="col-md-6 align-right">-->
			<div class="col-md-6 blockquote-reverse">	
				<div id="uploadDate">
					<em>Référencé le <?php echo $global_arr["file_upload_date"]; ?></em>
				</div>
				<div id="submitter"><a href="../../users/<?php echo $global_arr["user_name"]; ?>">Soumis par <?php echo $global_arr["user_name"]; ?></a>
				</div>
			</div>
		</div>
		<hr />

		<h2>Détails</h2>
		<div class="row">
			<!-- If a shortdesc is specified -->
			<div id="shortDesc">
				<h4 class="description">Description courte</h4>
				<?php if (empty($global_arr["file_short_description"])) {
					?>
					<div class="noDescription">
						<em>Aucune desciption courte n'est disponible. <a href="#">TODO Suggérer une description</a></em>
					</div>
					<?php
				}
				else{
					?>
					<?php
					echo $global_arr["file_short_description"];
				}
				?>
			</div>
		</div>
		
		<!-- If a long description is specified -->
		<div class="row">
			<!-- If a longdesc is specified -->
			<div id="shortDesc">
				<h4 class="description">Description longue</h4>
				<?php if (empty($global_arr["file_long_description"])) {
					?>
					<div class="noDescription">
						<em>Aucune desciption longue n'est disponible. <a href="#">TODO Suggérer une description détaillée</a></em>
					</div>
					<?php
				}
				else{
					?>
					<?php
					echo $global_arr["file_long_description"];
				}
				?>
			</div>
		</div>

		<hr />
		<h2>Liens et statistiques</h2>
		<!-- Links and stats -->
		<div class="row">
			<div id="hash">
				<h4>Hash IPFS</h4>
				<div id="ipfs-hash">
					<?php
						echo $global_arr["file_hash"]; 
					?>
					<!-- TODO Bouton copier -->
				</div>
				<h4>Mirroir HTTP</h4>
				<div>
					<?php
						if(empty($global_arr['file_mirror_http'])) {
							echo 'Aucun mirroir. <a href="#">Proposer une suggestion</a>';
						}
						else {
							echo $global_arr['file_mirror_http'];
						}
					?>
				</div>
			</div>

			
			<!-- TODO Stats (likes/dislikes/traffic..) -->
		</div>

		<hr />
		<h2>Commentaires des utilisateurs Monsite</h2>
		<!-- TODO -->
		<div class="row">
			Fonctionnalité à venir!
		</div>
	</div>
</body>
</html>