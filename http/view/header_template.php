<!-- TODO: Icons!! -->
<header class="navbar fixed-top navbar-light bg-light">

	<?php
		# Logo in the top header
		if (!isset($view_data["header_hide_logo"])) { ?>
			<span class="navbar-text logoLink">
				<a href="./">
					<img src="../public/images/logos/logo_120x44.png" alt="Logo monsite" class="logo120x44"/>
				</a>
			</span>
		<?php }

		# Search bar in header
		if (isset($view_data["header_search_query"])) { ?>
			<form class="navbar-text" action="./search.php" method="get">
				<input class="mainSearchBar" type="text" name="search" value="<?= $view_data["header_search_query"] ?>"/>
			</form>
		<?php }
	?>

	<ul class="navbar-text list-unstyled">
		<li>
			<a href="<?= $base ?>about"><span class="glyphicon glyphicon-question-sign"></span> Aide</a>
		</li>
		<li>
			<a href="<?= $base ?>submit.php"><span class="glyphicon glyphicon-file"></span> Soumettre un fichier</a>
		</li>

		<?php
			if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
				include "view/logged_in_header_dropdown.php";
			} else {
				include "view/logged_out_header_dropdown.php";
			}
		?>

	</ul>
	<?php
		# Display results filters if on the search page
		if(isset($view_data["header_search_query"])){
			echo "<br />";
			include "view/searchpage_filters.php";
		}
	?>
</header>