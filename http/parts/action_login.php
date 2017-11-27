<?php
	include_once "libs/password.php";
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Paris');

	/**
	 * Starts the login process.
	 *
	 */
	function login() {
		if(valid_login_postdata()) {
			$db = new Db();
			
			$password = $db -> quote(htmlspecialchars($_POST['password']));
			$email = $db -> quote(htmlspecialchars($_POST['email']));
			$referred_url = htmlspecialchars($_POST['redirectURL']);

			if(valid_password(htmlspecialchars($_POST['password']))) {
				$result = $db -> select("SELECT `id`,`username`,`password`,`email` FROM `users` WHERE `email`=".$email."");
				if(count($result) != 0) {
					if (password_verify($password, $result[0]['password'])) {
						$key = md5(uniqid(rand(), true));
						$db -> query("UPDATE `users` SET `tempkey`='".$key."' WHERE `email`=".$email."");

						$_SESSION["username"] = $result[0]['username'];
						$_SESSION["email"] = $result[0]['email'];
						$_SESSION["userid"] = $result[0]['id'];
						$_SESSION["key"] = $key;


						if (filter_var($referred_url, FILTER_VALIDATE_URL)) {
							header("Location: " . $referred_url);
						}
						else {
							header("Location: ../../index.php");
						}
					} else {
						exit(form_feedback("Mauvais mot de passe ou nom d'utilisateur."));
					}
				} else {
					exit(form_feedback("Compte d'utilisateur non trouvé."));
				}
			} else {
				exit(form_feedback("Le mot de passe que vous avez entré est trop court."));
			}
		} else {
			exit(form_feedback("Veuillez remplir les champs."));
		}
	}

	/**
	 * Checks if the password is longer than 8 characters.
	 *
	 * @param string of password.
	 * @return boolean.
	 */
	function valid_password($password) {
		if(strlen($password) >= 8) return true;
		return false;
	}

	/**
	 * Checks if the login form post variables aren't empty.
	 *
	 * @return boolean.
	 */
	function valid_login_postdata() {
		if(!empty($_POST['password']) && !empty($_POST['email'])) return true;
		return false;
	}

	/**
	 * Unhides the formfeedback and displays error text.
	 *
	 * @param string of error.
	 * @return javascript.
	 */
	function form_feedback($error) {
		echo '<script>';
		echo 'var element = document.getElementById("feedback").removeAttribute("style");';
		echo 'var element = document.getElementById("feedback").innerHTML ="'.$error.'";';
		echo '</script>';
	}
?>