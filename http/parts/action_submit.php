<?php
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Paris');

	/**
	 * Starts the submit process.
	 * Post data HAS to be valid at this point
	 *
	 */
	function submit() {
		$db = new Db();
		
		# Required values
		$title = $db -> quote(htmlspecialchars($_POST['title']));
		$ipfs_hash = $db -> quote(htmlspecialchars($_POST['ipfs_hash']));
		$category_id = $db -> quote(htmlspecialchars($_POST['cat']));
		$subcatgeroy_id = $db -> quote(htmlspecialchars($_POST['subcat']));

		# Optional values
		$http_mirror = (isset($_POST['http_mirror']) AND !empty($_POST['http_mirror'])) ? $db -> quote(htmlspecialchars($_POST['http_mirror'])) : false;

		echo $http_mirror;

		/*if(valid_password(htmlspecialchars($_POST['password']))) {
			$result = $db -> select("SELECT `id`,`username`,`password`,`email` FROM `users` WHERE `email`=".$email."");
			if(count($result) != 0) {
				if (password_verify($password, $result[0]['password'])) {
					$key = md5(uniqid(rand(), true));
					$db -> query("UPDATE `users` SET `tempkey`='".$key."' WHERE `email`=".$email."");

					$_SESSION["username"] = $result[0]['username'];
					$_SESSION["email"] = $result[0]['email'];
					$_SESSION["userid"] = $result[0]['id'];
					$_SESSION["key"] = $key;

					header("Location: ../../index.php");
				} else {
					exit(form_feedback("Mauvais mot de passe ou nom d'utilisateur."));
				}
			} else {
				exit(form_feedback("Compte d'utilisateur non trouvé."));
			}
		} else {
			exit(form_feedback("Le mot de passe que vous avez entré est trop court."));
		}*/	
	}

	/**
	 * Checks if the given string is shorter than specified. Useful to check
	 * if a value can fit in a database entry.
	 *
	 * @param string value to evaluate.
	 * @param integer max length.
	 * @return boolean.
	 */
	function smaller_length($value, $lenght) {
		if(strlen($value) <= $length) return true;
		return false;
	}

?>