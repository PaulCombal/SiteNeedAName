<?php
	$userLinks = "";
	$logoLink = "";
	$searchBarHTML = "";
	$base = "http://" . $_SERVER["HTTP_HOST"] . "/";

	if (isset($_SESSION["username"])) {
		//TODO fixer cette accumulation de maj et faire un truc clean
		$userLinks = '
		<div class="dropdown">
		  <li class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> '
		    	. $_SESSION["username"] . ' <span class="caret"></span>
		  </li>
		  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
		    <li><a href="' . $base . 'user/' . $_SESSION["username"] . '"><span class="glyphicon glyphicon-user"></span> Mon Profil Monsite</a></li>
		    <li><a href="'. $base . 'logout.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
		    <li role="separator" class="divider"></li>
		    <li><a href="#"><span class="glyphicon glyphicon-comment"></span> Discussions</a></li>
		    <li><a href="#"><span class="glyphicon glyphicon-wrench"></span> GitHub</a></li>
		  </ul>
		</div>';
	}
	else
	{
		$userLinks = '
		<div class="dropdown">
		  <li class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    	Non Connecté  <span class="caret"></span>
		  </li>
		  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
		    <li><a href="'.$base.'login.php"><span class="glyphicon glyphicon-log-in"></span> Connexion à mon compte</a></li>
		    <li><a href="'.$base.'register.php"><span class="glyphicon glyphicon-user"></span> Créer un compte Monsite</a></li>
		    <li role="separator" class="divider"></li>
		    <li><a href="#"><span class="glyphicon glyphicon-comment"></span> Discussions</a></li>
		    <li><a href="#"><span class="glyphicon glyphicon-wrench"></span> GitHub</a></li>
		  </ul>
		</div>';
	}

	if (!strstr($_SERVER["PHP_SELF"], "index.php")) {
		$logoLink = '<span class="navbar-text logoLink">'.
						'<a href="'.$base.'index.php">'.
							'<img src="'.$base.'images/logos/logo_120x44.png" alt="Logo monsite" class="logo120x44"/>'.
						'</a>'.
					'</span>';
	}

	if (strstr($_SERVER["PHP_SELF"], "search.php")) {
	$searchBarHTML = '
		<form class="navbar-text" action="./search.php" method="get">
			<input class="mainSearchBar" type="text" name="search" value="'. $_GET["search"]. '"/>
		</form>
	';
	}
?>

<!-- TODO: Icônes!! -->
<header class="navbar fixed-top navbar-light bg-light">
	<?php
		echo $logoLink;
		echo $searchBarHTML;
	?>
	<ul class="navbar-text list-unstyled">
		<li>
			<a href="<?php echo $base; ?>a-propos.php"><span class="glyphicon glyphicon-question-sign"></span> Aide</a>
		</li>
		<li>
			<a href="<?php echo $base; ?>submit.php"><span class="glyphicon glyphicon-file"></span> Soumettre un fichier</a>
		</li>
		<?php
			echo $userLinks;
		?>
	</ul>
	<?php
		#include results filters if on the search page
		if(strstr($_SERVER["PHP_SELF"], "search.php")){
			echo "<br />";
			include "./parts/searchPageFilters.php";
		}
	?>
</header>