<?php

require("model/frontend.php");

function display_main_page()
{
	$view_data["document_title"] = "MONSITE";
	$view_data["header_hide_logo"] = true;

	require("view/pages/index_view.php");
}

function display_file_page($file_id)
{

}

function display_search_page($search_term)
{

}

function display_register_page()
{
	require("view/pages/register_view.php");
	require("controller/action/action_register.php");


	if (isset($_POST['password']) && isset($_POST['email']) && isset($_POST['tovalidatepassword']) && isset($_POST['username'])) {
		if (!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['tovalidatepassword']) && !empty($_POST['username'])) {
			register();
		}
	}
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
				# TODO
				#if (User comes from the register or login page) {
					# redirect to the main page
				#}
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

function display_about_page()
{
	require("view/pages/about_view.php");
}

function display_user_page($user_unique_name)
{
	# TODO: is a user name verification needed here?
	try {
		$model_data = get_user_data($user_unique_name);
		$view_data["profile_page_user_name"] = $user_unique_name;
		$view_data["registration_date"] = &$model_data["reg_date"];
		$view_data["submitted_files"] = &$model_data["user_posts"];

		require("view/pages/user_profile_page_view.php");
	}
	catch (Exception $e) 
	{
		# TODO: upgrade
		# require("view/pages/error.php");
		die($e->getMessage());
	}
}

function display_submit_page()
{
	if(!isset($_SESSION["username"])) {
		header("Location: " . $base . "/register");
		print_r($_SESSION);
		exit;
	}

	require("controller/action/action_submit.php");
	
	if (isset($_POST['title']) && isset($_POST['ipfs_hash']) && isset($_POST['cat']) && isset($_POST['subcat'])) {
		if (!empty($_POST['title']) && !empty($_POST['ipfs_hash']) && !empty($_POST['cat']) && !empty($_POST['subcat'])) {
			submit();
			$_POST = [];
		}
	}

	require("view/pages/submit_hash_view.php");
}