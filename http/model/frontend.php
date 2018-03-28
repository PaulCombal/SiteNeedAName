<?php

require("model/database.php");
require("model/password.php");
require("model/urlify.php");

function get_file_data($id) {

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