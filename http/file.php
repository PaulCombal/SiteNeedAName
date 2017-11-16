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
		//boarf, no need to quote or htmlspecialchar here, it passed the isnumeric test, right?
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

		//Let's retrieve the flags now and append them to global_arr
		//boarf, no need to quote or htmlspecialchar here, it passed the isnumeric test, right?
		$prettySQL = "CALL getFlagsByFile(" . $file_id . ");";
		try {
			$result = $db -> select($prettySQL);
		} catch (Exception $e) {
			die("Error: " . $e->getMessage());
		}

		if (count($result) <> 1) {
			throw new Exception("[Erreur 3] Incohérence de données", 1);
		}

		$global_arr = array_merge($global_arr, $result[0]);
		$global_arr["user_is_logged_in"] = isset($_SESSION["userid"]) && !empty($_SESSION["userid"]) && is_numeric($_SESSION["userid"]);

		//If user is logged in, we want to retrieve the flags already applied by the currently logged in user
		$is_file_liked = false;
		$is_file_disliked = false;
		$is_file_moderated = false;
		$is_file_banned = false;

		if ($global_arr["user_is_logged_in"]) {
			$prettySQL = "CALL getFlagsByUserAndFile(" . $_SESSION["userid"] . ", " . $file_id . ");";
			
			try {
				$result = $db -> select($prettySQL);

				foreach ($result as &$flag) {
					switch ($flag["flagType"]) {
					 	case 'LIKE':
					 		$is_file_liked = true;
					 		break;

					 	case 'DISLIKE':
					 		$is_file_disliked = true;
					 		break;

						case 'BANNED':
					 		$is_file_banned = true;
					 		break;

					 	case 'MODERATED':
					 		$is_file_moderated = true;
					 		break;

					 	default:
					 		# Nothing. Improve error handling here?
					 		break;
					 }
				}

			} catch (Exception $e) {
				die("Error: " . $e->getMessage());
			}
		}
	}
	catch(Exception $e)	{
		die("Une erreur est survenue lors de la récupération des informations fichier :( <br>" . $e->getMessage());
	}

	// We are officially DONE with preloading we now know about:

	// * The file itself, everything needed is in global_arr
	// * If we are a logged in user, in global_arr
	// * The overall flags applied to this file (number of likes, dislikes, etc), in global_arr
	// * The flags applied by ourself, if we are logged, in vars like is_file_*
?>

<!DOCTYPE html>
<html lang="fr" data-file-id="<?php echo $file_id;?>">
<head>
	<title>MONSITE</title>
	
	<?php /* We will not use general head includes because we need the full jQuery version for POST requests*/ ?>

	<?php $base = "http://" . $_SERVER["HTTP_HOST"] . "/"; ?>

	<!-- Main CSS rules -->
	<link rel="stylesheet" href="<?php echo $base; ?>css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $base; ?>css/custom_general.css" />

	<!-- Necessary scripts for jQuery and Bootstrap -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	
	<!-- Custom files start here -->

	<!-- CSS -->
	<link rel="stylesheet" href="../../css/custom_file.css" />

	<!-- Markdown to HTML -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.8.0/showdown.min.js"></script>
	<script src="../../js/md2html.js"></script>

	<!-- Flagging -->
	<script src="../../js/custom_file.js"></script>

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
			<div class="col-md-7">
				<h1 id="fileTitle">
					<?php 
						echo $global_arr["file_title"]; 
						if($is_file_banned) 
							echo " - [FICHIER BANNI PAR VOUS-MÊME]";
						if($is_file_moderated) 
							echo " - [FICHIER APPROUVÉ PAR VOUS-MÊME]"; 
					?>
				</h1>
				<?php 
					if($global_arr["moderated"]) echo '<h3><span class="glyphicon glyphicon-ok"></span> Fichier vérifié manuellment</h3>'; /* TODO Style + explications */ 
					if($global_arr["banned"]) echo '<h3><span class="glyphicon glyphicon-warning-sign"></span> Fichier BANNI</h3>'; /* TODO Style + explications */ 
				?>
			</div>
			<div class="col-md-5 blockquote-reverse">	
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

				<h4>Votes</h4>
				<div>
					<br />

					<!-- Flag buttons group -->
					<div class="btn-group">
						<a id="likeBut" href="javascript:void(0)" class="btn btn-primary<?php if($is_file_liked) echo " active"; ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>
						<a id="dislikeBut" href="javascript:void(0)" title="Le fichier n'est pas conforme à la description ou est dangereux" class="btn btn-primary<?php if($is_file_disliked) echo " active"; ?>"><span class="glyphicon glyphicon-thumbs-down"></span> </a>
					</div>

					<!-- Like / dislike ratio bar -->
					<table id="likeRatio">
						<tr>
							<th class="numberLikes">
								<?php echo $global_arr["likes"]; ?>
							</th>
							<th class="likeProgressBarColumn">
								<div id="likeProgressBar" class="progress" data-initial-likes="<?php echo $global_arr["likes"]; ?>" data-initial-dislikes="<?php echo $global_arr["dislikes"]; ?>">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
									<span class="sr-only">0% liked</span>
									</div>
								</div>
							</th>
							<th class="numberDislikes">
								<?php echo $global_arr["dislikes"]; ?>
							</th>
						</tr>
					</table>

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