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
		$name = $db -> quote(htmlspecialchars($_GET['name']));
		$result = $db -> select ("CALL getUserDataByName(" . $name . ");");
		
		# Get user info
		if (count($result) <> 1){
			throw new Exception("Erreur: Utilisateur inaccessible", 1);
		}

		$global_arr['email'] = $result[0]['email']; //Will only be used/seen by mods
		$global_arr['reg_date'] = $result[0]['reg_date'];
		$global_arr['user_id'] = $result[0]['userId'];

		echo "1. " . $db->error();
		# Get user posts
		$result = $db -> select ("CALL getUserPostsById(" . $global_arr['user_id'] . ", 10, 1);");

		echo "2. " . $db->error();
		
	}
	catch(Exception $e)	{
		die("Une erreur est survenue lors de la récupération des infos utilisateur :( <br>" . $e->getMessage());
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

	<div class="container">
		<div class="row">
			<div class="userHeader name">
				<h3>
					<?php echo $_GET['name']; ?>
				</h3>
				<span class="registerDate">Membre depuis le <?php echo $global_arr['reg_date']; ?></span>
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
			<div class="userHeader karma">
				<h3>
					Fichiers
				</h3>
				<?php print_r($result); ?>
				<!-- Stats, badges, etc -->
			</div>
		</div>
	</div>
	
</body>
</html>