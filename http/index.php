<?php


require("controller/frontend.php");


//Start the session
if(!isset($_SESSION)) {
	session_start();
}

if (!isset($_GET["action"])) {
	display_main_page();
}
else {
	switch ($_GET["action"]) {

		# Display a file etails
		case 'file':
			if (isset($_GET["id"]) && !empty($_GET["id"])) {
				display_file_page($_GET["id"]);
			} else {
				display_main_page();
			}
			break;

		# Display the search page
		case 'search':
			if (isset($_GET["q"]) && !empty($_GET["q"])) {
				display_search_page($_GET["q"]);
			} else {
				display_main_page();
			}
			break;

		# Display the login page
		case 'login':
			display_login_page();
			break;

		# Display the page for a new user to register
		case 'register':
			display_register_page();
			break;

		# Display the about page
		case 'about':
			display_about_page();
			break;

		# Display a user's profile page
		case 'user':
			if (isset($_GET["user"]) && !empty($_GET["user"])) {
				display_user_page($_GET["user"]);
			} else {
				display_main_page();
			}
			break;

		# Display the hash submission page
		case 'submit':
			display_submit_page();
			break;


		
		default:
			display_main_page();
			break;
	}
}