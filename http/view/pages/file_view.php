<!DOCTYPE html>
<html lang="fr" data-file-id="<?php echo $file_id;?>">
<head>
	<title><?php echo $view_data['all_file_data']['file_details']['file_title']; ?> | IPFS France</title>
	
	<?php /* We will not use general head includes because we need the full jQuery version for POST requests*/ ?>

	<!-- Main CSS rules -->
	<link rel="stylesheet" href="../../public/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../../public/css/custom_general.css" />

	<!-- Necessary scripts for jQuery and Bootstrap -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	
	<!-- Custom files start here -->

	<!-- CSS -->
	<link rel="stylesheet" href="../../public/css/custom_file.css" />

	<!-- Markdown to HTML -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.8.0/showdown.min.js"></script>
	<script src="../../public/js/md2html.js"></script>

	<!-- Flagging -->
	<script src="../../public/js/custom_file.js"></script>

	<!-- clipboard.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
</head>
<body>

	<?php
		include "view/header_template.php";
	?>

	<div class="container">
		<!-- Breadcrumb-->
		<div class="row">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">
						<?php
							echo $view_data['all_file_data']['file_details']['category'];
						?>
					</a>
				</li>
				<li class="breadcrumb-item">
					<a href="#">
						<?php
							echo $view_data['all_file_data']['file_details']['subcategory'];
						?>
					</a>
				</li>
				<li class="breadcrumb-item active">
					<?php
						echo $view_data['all_file_data']['file_details']['file_title'];
					?>
				</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-md-7">
				<h1 id="fileTitle">
					<?php 
						echo $view_data['all_file_data']['file_details']['file_title']; 
						if($view_data['all_file_data']['user_banned']) 
							echo " - [FICHIER BANNI PAR VOUS-MÊME]";
						if($view_data['all_file_data']['user_moderated'])
							echo " - [FICHIER APPROUVÉ PAR VOUS-MÊME]"; 
					?>
				</h1>
				<?php 
					if($view_data['all_file_data']['file_flags']['moderated']) 
						echo '<h3><span class="glyphicon glyphicon-ok"></span> Fichier vérifié manuellment</h3>'; /* TODO Style + explications */ 
					if($view_data['all_file_data']['file_flags']['banned']) 
						echo '<h3><span class="glyphicon glyphicon-warning-sign"></span> Fichier BANNI</h3>'; /* TODO Style + explications */ 
				?>
			</div>
			<div class="col-md-5 blockquote-reverse">	
				<div id="uploadDate">
					<em>Référencé le <?= $view_data['all_file_data']['file_details']['file_upload_date'] ?></em>
				</div>
				<div id="submitter">
					<a href="../../user/<?= $view_data['all_file_data']['file_details']['user_name'] ?>">Soumis par <?= $view_data['all_file_data']['file_details']['user_name'] ?></a>
				</div>
			</div>
		</div>
		<hr />

		<div class="row">
			<h2>Détails</h2>
			<!-- If a shortdesc is specified -->
			<div id="shortDesc">
				<h4 class="description">Description courte</h4>
				<?php 
					if (empty($view_data['all_file_data']['file_details']['file_short_description'])) {
					?>
					<div class="noDescription">
						<em>Aucune desciption courte n'est disponible. <a href="<?= $view_data['suggest_page_url'] ?>">Suggérer une description</a></em>
					</div>
					<?php
				}
				else{
					echo $view_data['all_file_data']['file_details']['file_short_description'];
				}
				?>
			</div>
		</div>
		
		<!-- If a long description is specified -->
		<div class="row">
			<!-- If a longdesc is specified -->
			<div id="longDesc">
				<h4 class="description">Description longue</h4>
				<?php if (empty($view_data['all_file_data']['file_details']['file_long_description'])) {
					?>
					<div class="noDescription">
						<em>Aucune desciption longue n'est disponible. <a href="<?= $view_data['suggest_page_url'] ?>">Suggérer une description détaillée</a></em>
					</div>
					<?php
				}
				else{
					?>
				<div id="text-longDesc">
					<?= $view_data['all_file_data']['file_details']['file_long_description'] ?>
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
						<?= $view_data['all_file_data']['file_details']['file_hash'] ?>
					</span>
					<br />
					<br />
					<div class="btn-group">
						<a href="javascript:void(0)" data-clipboard-target="#hash-text" class="btn btn-primary"><span class="glyphicon glyphicon-copy"></span> Copier</a>
						<a href="http://127.0.0.1:8080<?= $view_data['all_file_data']['file_details']['file_hash'] ?>" target="_blank" title="Le service IPFS doit être lancé sur votre machine" class="btn btn-primary"><span class="glyphicon glyphicon-cloud-download"></span> Télécharger en navigateur</a>
						<a href="http://ipfs.io<?= $view_data['all_file_data']['file_details']['file_hash'] ?>" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-save-file"></span> Mirroir HTTP ipfs.io</a>
					</div>
				</div>
				<br />

				<h4>Votes</h4>
				<div>
					<br />

					<!-- Flag buttons group -->
					<div class="btn-group">
						<a id="likeBut" href="javascript:void(0)" class="btn btn-primary<?php if($view_data['all_file_data']['user_liked']) echo " active"; ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>
						<a id="dislikeBut" href="javascript:void(0)" title="Le fichier n'est pas conforme à la description ou est dangereux" class="btn btn-primary<?php if($view_data['all_file_data']['user_liked']) echo " active"; ?>">&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span> </a>
					</div>

					<!-- Like / dislike ratio bar -->
					<table id="likeRatio">
						<tr>
							<th class="numberLikes">
								<?= $view_data['all_file_data']['file_flags']['likes'] ?>
							</th>
							<th class="likeProgressBarColumn">
								<div id="likeProgressBar" class="progress" data-initial-likes="<?= $view_data['all_file_data']['file_flags']['likes'] ?>" data-initial-dislikes="<?= $view_data['all_file_data']['file_flags']['dislikes'] ?>">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
									<span class="sr-only">0% liked</span>
									</div>
								</div>
							</th>
							<th class="numberDislikes">
								<?= $view_data['all_file_data']['file_flags']['dislikes'] ?>
							</th>
						</tr>
					</table>

				<br />
				<h4>Mirroir HTTP</h4>
				<div>
					<?php
						if(empty($view_data['all_file_data']['file_details']['file_http_mirror'])) {
							echo 'Aucun mirroir. <a href="' . $view_data['suggest_page_url'] . '">Proposer une suggestion</a>';
						}
						else {
							echo '<a target="_blank" href="';
							echo $view_data['all_file_data']['file_details']['file_http_mirror'];
							echo '">';
							echo $view_data['all_file_data']['file_details']['file_http_mirror'];
							echo '</a>';
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