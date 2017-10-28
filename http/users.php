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

		# Get user posts
		$result = $db -> select ("CALL getUserPostsById(" . $global_arr['user_id'] . ", 10, 1);");
		
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
							foreach ($result as &$row) {
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
										echo '<a href="./files/<TODO put file ID here>/' . $row['title'] .'">Consulter</a>';
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