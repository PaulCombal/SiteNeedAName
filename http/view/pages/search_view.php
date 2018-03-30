<!DOCTYPE html>
<html>
<head>
	<title><?= $view_data['document_title'] ?> | IPFS France</title>
	<?php include "view/general_head_includes.php"; ?>
	<!-- Custom CSS for the search page -->
	<link rel="stylesheet" href="public/css/custom_search.css" />

	<!-- Custom scripts (clipboard + hover) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
	<script src="public/js/searchPage.js"></script>
</head>
<body>
	<?php
		include "view/header_template.php";
	?>
	<div class="container">
	<?php
		if (count($view_data['search_results']) === 0) {
			echo "<em>Aucun résultat trouvé.. Vous aurez peut-être plus de chance avec expression plus courte.</em>";
		}
		else {
			foreach ($view_data['search_results'] as &$row) {
				echo '<div class="row">';
				echo '<a class="result-mainLink" href="file/' . $row['file_id'] . '/' . urlify($row['file_title']) . '">' . $row['file_title'] . '</a>';
				
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
		}
	?>
	</div>

</body>
</html>