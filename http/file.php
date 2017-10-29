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
	<link rel="stylesheet" href="../../css/custom_file.css" />


	<!-- Markdown to HTML Script -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.8.0/showdown.min.js"></script>
	<script src="../../js/md2html.js"></script>

	<!-- clipboard.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
</head>
<body>

	<?php
		include "./parts/header.php";
	?>

	<div class="container">
		<!-- Breadcrumb-->
		<div class="row">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">
						<?php
							echo $global_arr["category"];
						?>
					</a>
				</li>
				<li class="breadcrumb-item">
					<a href="#">
						<?php
							echo $global_arr["subcategory"];
						?>
					</a>
				</li>
				<li class="breadcrumb-item active">
					<?php
						echo $global_arr["file_title"];
					?>
				</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-md-6">
				<h1 id="fileTitle"><?php echo $global_arr["file_title"];?></h1>
			</div>
			<div class="col-md-6 blockquote-reverse">	
				<div id="uploadDate">
					<em>Référencé le <?php echo $global_arr["file_upload_date"]; ?></em>
				</div>
				<div id="submitter"><a href="../../users/<?php echo $global_arr["user_name"]; ?>">Soumis par <?php echo $global_arr["user_name"]; ?></a>
				</div>
			</div>
		</div>
		<hr />

		<div class="row">
			<h2>Détails</h2>
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
			<div id="longDesc">
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
				<div id="text-longDesc">
					<?php echo $global_arr["file_long_description"]; ?>
				</div>
					<?php
					}
				?>
			</div>
		</div>

		<hr />
		<!-- Links and stats -->
		<div class="row">
			<h2>Liens et statistiques</h2>
			<div id="hash">
				<h4>Hash IPFS</h4>
				<div id="ipfs-hash">
					<span id="hash-text">
						<?php
							echo $global_arr["file_hash"]; 
						?>
					</span>
					<!-- TODO Bouton copier -->
					<br />
					<br />
					<div class="btn-group">
						<a href="javascript:void(0)" data-clipboard-target="#hash-text" class="btn btn-primary"><span class="glyphicon glyphicon-copy"></span> Copier</a>
						<a href="http://127.0.0.1:8080/<?php echo $global_arr['file_hash'];?>" target="_blank" title="Le service IPFS doit être lancé sur votre machine" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-download"></span> Télécharger en navigateur</a>
						<a href="http://ipfs.io/<?php echo $global_arr["file_hash"]; ?>" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-save-file"></span> Mirroir HTTP ipfs.io</a>
					</div>
				</div>
				<br />
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
		<!-- TODO -->
		<div class="row">
			<h2>Commentaires des utilisateurs Monsite</h2>
			Fonctionnalité à venir!
		</div>
	</div>
</body>
</html>