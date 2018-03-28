<?php

	date_default_timezone_set('Europe/Paris');

	/**
	 * Starts the register process.
	 *
	 */
	function register() {
		$db = new Db();

		$password = $db -> quote(htmlspecialchars($_POST['password']));
		$toValidatePassword = $db -> quote(htmlspecialchars($_POST['tovalidatepassword']));
		$email = $db -> quote(htmlspecialchars($_POST['email']));
		$username = $db -> quote(htmlspecialchars($_POST['username']));

		try {
			if(valid_register_postdata()) {
				if(!is_temp_mail(htmlspecialchars($_POST['email']))) {
					if(passwords_match($password,$toValidatePassword)) {
						if(valid_password(htmlspecialchars($_POST['password']))) {
							if(!already_registered($email,$username,$db)) {
								$hashed_password = password_hash($password, PASSWORD_BCRYPT);
								$key = md5(uniqid(rand(), true));

								$result = $db -> select("CALL createNewUser(" . $email . ", " . $username . ", '" . $hashed_password . "', '" . $key . "');"); 

								$_SESSION["username"] = htmlspecialchars($_POST['username']);
								$_SESSION["email"] = htmlspecialchars($_POST['email']);
								$_SESSION["userid"] = $result[0]['user_id'];
								$_SESSION["key"] = $key;

								echo '<script>window.location.replace(window.location.origin)</script>';
							} else {
								exit(form_feedback("Cette adresse e-mail ou nom d'utilisateur existent déjà."));
							}
						} else {
							exit(form_feedback("Le mot de passe doit être plus."));
						}
					} else {
						exit(form_feedback("Les mots de passe renseignés sont différents."));
					}
				} else {
					exit(form_feedback("Veuillez utiliser une adresse e-mail correcte."));
				}
			} else {
				exit(form_feedback("Veuillez remplir les champs."));
			}
		} catch(Exception $e) {
			form_feedback($e->getMessage());
		}
	}

	/**
	 * Checks if the register form post variables aren't empty.
	 *
	 * @return boolean.
	 */
	function valid_register_postdata() {
		if(!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['tovalidatepassword']) && !empty($_POST['username'])) return true;
		return false;
	}

	/**
	 * Checks if the provided email address is blacklisted.
	 *
	 * @param string of email.
	 * @return boolean.
	 */
	function is_temp_mail($mail) {
    	$mail_domains_ko = file('https://raw.githubusercontent.com/martenson/disposable-email-domains/master/disposable_email_blacklist.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    	
    	if ($mail_domains_ko === false) {
    		throw new Exception("Désolé, nous ne pouvons pas valider votre addresse mail :( Réessayez plus tard!", 1);
    		return false;
    	}

    	return in_array(explode('@', htmlspecialchars($mail))[1], $mail_domains_ko);
	}

	/**
	 * Checks if the passwords match at register.
	 *
	 * @param string of password.
	 * @param string of confirmed password.
	 * @return boolean.
	 */
	function passwords_match($password,$confirm) {
    	if($password == $confirm) return true;
		return false;
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
	 * Checks if there is already a user registered using this mail address or username.
	 *
	 * @param string of mail.
	 * @param string of username.
	 * @param object of database.
	 * @return boolean.
	 */
	function already_registered($mail, $username, $db) {
		#Arguments already quoted
		$result = $db -> select("CALL isAlreadyRegistered(" . $username . ", " . $mail . ");");
		if($result[0]["alreadyRegistered"] == 1) return true;
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