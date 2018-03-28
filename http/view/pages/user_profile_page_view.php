<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?= $view_data["profile_page_user_name"] ?> | IPFS France</title>
	<?php include "view/general_head_includes.php"; ?>
</head>
<body>

	<?php
		include "view/header_template.php";
	?>

	<div class="container">
		<div class="row">
			<div class="userHeader name">
				<h3>
					<?= $view_data["profile_page_user_name"] ?>
				</h3>
				<span class="registerDate">Membre depuis le <?= $view_data["registration_date"] ?></span>
				<hr />
			</div>		
		</div>
		<div class="row">
			<div class="userHeader karma">
				<h3>
					Karma
				</h3>
				<span>Fonctionnalité à venir!</span>
				<!-- Stats, badges, etc -->
			</div>
		</div>
		<div class="row">
			<div class="userHeader files">
				<h3>
					Fichiers
				</h3>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Titre</th>
							<th>Description</th>
							<th>Date de référencement</th>
							<th>Page dédiée</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($view_data["submitted_files"] as &$row) {
								echo "<tr>";
									echo "<td>";
										echo $row['title'];
									echo "</td>";
									echo "<td>";
										echo $row['short_desc'];
									echo "</td>";
									echo "<td>";
										echo $row['upload_date'];
									echo "</td>";
									echo "<td>";
										echo '<a href="../télécharger/' . $row['file_id'] . '/' . $row['title'] .'">Consulter</a>';
									echo "</td>";
							 	echo "</tr>";
							 } 
							
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</body>
</html>