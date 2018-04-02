<!DOCTYPE html>
<html>
<head>
	<title>IPFS France</title>
	<?php
		session_start(); // Needed here because we are not using the controller
		set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );
		include 'view/general_head_includes.php';
	?>
</head>
<body>

	<?php
		include "view/header_template.php";
	?>

	<div class="mainWrapper">
		<h1>Oups, le contenu recherché n'est pas là..</h1>
		<h2>Il a sûrement été déplacé autre part ou retiré du site</h2>

		<br />
		<h1>TODO: Mettre une mascotte qui pleure en gros sur cette page.</h1>
		Idée à la con: mettre un petit goodie aléatoire?
	</div>

</body>
</html>