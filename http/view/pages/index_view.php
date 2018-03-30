<!DOCTYPE html>
<html>
<head>
	<title><?= $view_data['document_title'] ?></title>
	<?php include "view/general_head_includes.php"; ?>
</head>
<body>

	<?php
		include "view/header_template.php";
	?>

	<div class="indexContainer">
		<div class="mainLogo">
			<img src="public/images/logos/logo_272x92.png" alt="Logo Monsite" />
		</div>
		<div class="searchBar">
			<form action="search" method="get">
				<input class="mainSearchBar" type="text" name="q" autofocus />
				<br />
				<input class="mainSearchButton form-control" type="submit" value="Recherche Monsite" />
				<input class="advancedSearchButton form-control" type="button" value="Recherche Avancée" />
			</form>
		</div>
	</div>

</body>
</html>