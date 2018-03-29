<div class="dropdown">
	<li class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= $_SESSION["username"] ?> <span class="caret"></span>
	</li>
	<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
		<li><a href="<?= $base . 'user/' . $_SESSION["username"] ?>"><span class="glyphicon glyphicon-user"></span> Mon Profil Monsite</a></li>
		<li><a href="<?= $base ?>logout"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="#"><span class="glyphicon glyphicon-comment"></span> Discussions</a></li>
		<li><a href="#"><span class="glyphicon glyphicon-wrench"></span> GitHub</a></li>
	</ul>
</div>