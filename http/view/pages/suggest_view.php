<!DOCTYPE html>
<html>
<head>
	<title>Améliorer IPFS France</title>
	<?php include "view/general_head_includes.php"; ?>
</head>
<body>
	<?php include "view/header_template.php"; ?>
	<div class="container">
		<ul class="nav nav-pills">
			<li class="active">
				<a href="#1b" data-toggle="tab">Descriptions courtes</a>
			</li>
			<li>
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
					foreach ($view_data['file_descriptions'] as &$desc) {
						if ($desc['desctype'] === 'short') {
							echo "<div class=\"row\">";
							echo "\"{$desc['description']}\" par {$desc['username']} le {$desc['date_last_modified']}";
							echo "</div>";
						}
					}
				?>

				<div class="row">
					<h3>
						Proposer une description courte
					</h3>
					<form action="<?= $view_data['file_id'] ?>" method="post" class="form-inline">
						<input name="desc" class="form-control" placeholder="Tapez ici votre description courte" style="width: 60%;" pattern=".{1,60}" maxlength="60" required value="<?= empty($view_data['user_descriptions']['short']) ? '' : $view_data['user_descriptions']['short'] ?>" />
						<input type="hidden" name="short" />
						<input type="submit" class="btn btn-default" />
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
					foreach ($view_data['file_descriptions'] as &$desc) {
						if ($desc['desctype'] === 'long') {
							echo "<div class=\"row\">";
							echo "\"{$desc['description']}\"<br> par {$desc['username']} le {$desc['date_last_modified']}";
							echo "</div>";
						}
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