<?php

require("model/database.php");
require("model/password.php");
require("model/urlify.php");

function get_file_data($id) {
	$db = new Db();
	$db->connect();

	$file_details = $db -> select("CALL getFileByID(" . $id . ");");
	if (count($file_details) <> 1) {
		throw new Exception("Désolé, ce fichier a été déréférencé de façon permanente.", 1);
	}
	$view_data['file_details'] = $file_details[0];

	$file_flags = $db -> select("CALL getFlagsByFile(" . $id . ");");
	if (count($file_flags) <> 1) {
		throw new Exception("Désolé, le fichier que vous avez demandé n'a pas d'informations cohérentes. Si besoin, contactez un webstre ou reportez cette erreur sur une plateforme connue des développeurs (github...)", 1);
	}
	$view_data['file_flags'] = $file_flags[0];
	
	//If user is logged in, we want to retrieve the flags already applied by the currently logged in user
	$view_data['user_liked'] = false;
	$view_data['user_disliked'] = false;
	$view_data['user_banned'] = false;
	$view_data['user_moderated'] = false;
	$user_logged_in = isset($_SESSION["userid"]) && !empty($_SESSION["userid"]) && is_numeric($_SESSION["userid"]);
	if ($user_logged_in) {
		
		$prettySQL = "CALL getFlagsByUserAndFile(" . $_SESSION["userid"] . ", " . $id . ");";
		$result = $db -> select($prettySQL);


		foreach ($result as &$flag) {
			switch ($flag["flagType"]) {
			 	case 'LIKE':
			 		$view_data['user_liked'] = true;
			 		break;

			 	case 'DISLIKE':
			 		$view_data['user_disliked'] = true;
			 		break;

				case 'BANNED':
			 		$view_data['user_banned'] = true;
			 		break;

			 	case 'MODERATED':
			 		$view_data['user_moderated'] = true;
			 		break;

			 	default:
			 		die("Our database is compromised, brb, hopefully");
			 		break;
			 }
		}
	}

	return $view_data;
}

function get_user_data($user_unique_name) {

	$db = new Db();
	$name = $db -> quote(htmlspecialchars($user_unique_name));
	$result = $db -> select ("CALL getUserDataByName(" . $name . ");");
	
	# Get user info
	if (count($result) <> 1){
		throw new Exception("Désolé, cet utilisateur n'existe pas ou a supprimé son compte", 1);
	}

	$retrieved_data = [];
	$retrieved_data['email'] 	= $result[0]['email']; //Will only be used/seen by mods
	$retrieved_data['reg_date'] = $result[0]['reg_date'];
	$retrieved_data['user_id'] 	= $result[0]['userId'];

	# Get user posts
	$result = $db -> select ("CALL getUserPostsById(" . $retrieved_data['user_id'] . ", 10, 1);");
	$retrieved_data['user_posts'] = $result;

	return $retrieved_data;
}

function get_search_results($query) {
	$db = new Db();
	$db->connect(); // Necessary? TODO

	# TODO Review procedure to only return required fields
	# with a correct name
	$result = $db -> select ("CALL getPostsBySearch(" . $db -> quote($query) . ", NULL, NULL, NULL, NULL);");
	return $result;
}

function get_file_suggestions($file_id) {
	$db = new Db();
	$aDescs = $db -> select("CALL getPendingDescriptions(" . $file_id . ");");

	if($aDescs === false) {
		die("ERROR #2: Impossible to retrieve pending descriptions.");
	}

	return $aDescs;
}

# Returns the currently logged in submitted suggestions
function submit_description($file_id, $desc_text, $is_short_desc) {
	$db = new Db();

	$desc_text = $db -> quote($desc_text);
	$is_short_desc = $is_short_desc == true ? 'TRUE' : 'FALSE';
	$user_id = $_SESSION['userid'];
	$prettySQL = "CALL insertNewDescription({$file_id}, {$user_id}, {$desc_text}, {$is_short_desc});";

	echo $prettySQL;

	#$user_descs = $db -> select($prettySQL);
	#return $user_descs;

	# 'short' => '', leave empty if no desc specified beforehand
	return ['short' => 'La description courte que j\'ai tapé auparavant', 'long' => 'La description longue de mon choix avec support MD'];
}