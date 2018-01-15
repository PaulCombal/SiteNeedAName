<?php

require("model/frontend.php");

function display_main_page()
{
	$view_data["document_title"] = "MONSITE";
	$view_data["header_hide_logo"] = true;
	$view_data["username"] = $_SESSION["username"];

	require("view/pages/index_view.php");
}

function display_file_page($file_id)
{

}

function display_search_page($search_term)
{

}

function display_login_page()
{

	# If user failed to login and has been redirected again to the login page, 
	# we do not want a redirection to this again on a successful try,
	# so we keep the last valid redirection page
	if(isset($_POST["redirectURL"])) {
		$view_data["redirect_if_success"] = $_POST["redirectURL"];
	}
	else if (isset($_SERVER["HTTP_HOST"])) { #If the http host name is available
		if(isset($_SERVER["REQUEST_SCHEME"])) {
			if(isset($_SERVER["HTTP_REFERER"]) &&  
			   same_origin($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"], $_SERVER["REQUEST_SCHEME"])) 
			{
				# We redirect to the last visited page, if the last visited page was on this website
				$view_data["redirect_if_success"] = $_SERVER["HTTP_REFERER"];
			}
			else 
			{
				# The last visited page is not available, or was not on this website
				$view_data["redirect_if_success"] = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];
			}
		}
		else {
			# The HTTP scheme is not available. Ancient browser, developer, or crawler here
			$view_data["redirect_if_success"] = $_SERVER["PHP_SELF"];
		}
	}
	else {
		# The HTTP host name is not available. Ancient browser, developer, or crawler here
		$view_data["redirect_if_success"] = $_SERVER["PHP_SELF"];
	}

	require("view/pages/login_view.php");
	require("controller/action/action_login.php");

	if (!empty($_POST['email']) && !empty($_POST['password'])) {
		login();
	}
}