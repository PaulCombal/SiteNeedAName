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


		
		default:
			display_main_page();
			break;
	}
}