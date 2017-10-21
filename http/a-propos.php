<?php
	//Start the output buffer
	ob_start();
	
	//Start the session
	if(!isset($_SESSION)) {
		session_start();
	}

	//include plugins and database lib
	include "./parts/includes.php";

	//Create a database interface
	//On failure, displays a nice error message and nothing else.
	$db = new Db();
	try
	{
		$db->connect();
	}
	catch(Exception $e)
	{
		ob_clean();
		die("An error occurred connecting to the database: " . $e->getMessage());
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MONSITE - À propos</title>
	<?php include "parts/general_head_includes.php"; ?>
</head>
<body>

<?php

	include "./parts/header.php";
?>

<div class="mainWrapper">

	<h1>Qu'est-ce que Monsite?</h1>

	<h1>Comment utiliser Monsite?</h1>

	<h1>Quelles sont les bonnes pratiques?</h1>

	<h1>Je n'ai toujours pas compris quelque chose...</h1>

	Depuis logtemps blala. Vous invite à participer à l'avènement d'un nouveau monde.Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in mi ipsum. Etiam viverra suscipit arcu, at tristique ligula tempor eu. Fusce posuere ullamcorper nulla, luctus congue purus posuere sit amet. In non neque sed augue consequat semper. Nunc nec ligula quis quam tempus tempus. Sed accumsan vel turpis et blandit. Ut non semper diam. Quisque congue diam a lacinia luctus. Cras mattis metus mauris, porttitor iaculis metus venenatis quis. Integer finibus a neque id fermentum. Curabitur tristique dolor in ligula hendrerit lacinia. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut tempus, ex sit amet viverra ultricies, erat magna rhoncus dui, id faucibus augue odio a arcu. Vestibulum varius feugiat arcu, eu suscipit lorem blandit non. Proin cursus elementum pulvinar. Nunc congue at ipsum eu faucibus.

	Nulla libero nisi, lacinia ut imperdiet eget, fermentum ut nibh. Pellentesque a laoreet mauris, nec egestas est. Praesent vel quam faucibus lorem eleifend sollicitudin sed tristique augue. Morbi a posuere tortor. Vestibulum nunc odio, ornare eu ligula a, dictum malesuada massa. Aliquam varius lectus sagittis massa congue finibus. Nullam pulvinar, orci eu consectetur aliquam, arcu libero lacinia massa, ut efficitur dolor libero tincidunt risus. Nulla vulputate, odio sit amet vehicula feugiat, nibh velit facilisis ipsum, sit amet fermentum quam odio eget erat.

	Cras consectetur, libero a eleifend sagittis, odio diam viverra arcu, et congue lorem nulla at diam. Nam dignissim ultrices erat, sit amet molestie massa tempor quis. Nullam finibus, leo at scelerisque semper, nisl neque porttitor elit, eget vehicula leo tellus in lectus. Curabitur mattis, odio id vestibulum vulputate, nulla lectus feugiat odio, ut placerat libero sapien ut sapien. Sed eu molestie leo, et tincidunt lacus. Nulla dignissim dapibus metus, sed dapibus est mattis vitae. Donec aliquet sapien vitae massa blandit sagittis. Quisque a ultrices enim, vitae lobortis sapien. Donec aliquet, risus at sagittis euismod, mi lacus elementum leo, id molestie sapien odio quis lectus.

	Mauris sodales fermentum pellentesque. Integer vehicula justo quis ipsum cursus tincidunt. Nulla interdum gravida nunc vitae consectetur. Fusce tempus nibh eros, at euismod quam finibus non. Pellentesque vulputate dapibus finibus. Aliquam libero diam, imperdiet vel euismod vel, condimentum id dui. Sed at quam id dui suscipit pretium non malesuada eros. Vivamus at maximus ex. Curabitur et justo ut nisi commodo rutrum. Nam tincidunt porta sapien a semper.

	<br />
	<br />

	<a href="javascript:history.back()">> Retour</a>
</div>

<?php
	ob_end_flush();
?>

</body>
</html>