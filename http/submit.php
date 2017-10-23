<?php
	//ob_start();
	session_start();


	//On success redirection is handled in the function submit();

    // Include plugin.
    //include_once "../../plugins/private_signup_plugin.php";

    // Redirect if the user not logged in.
	if(!isset($_SESSION["username"])) {
	    header("Location: ./register.php");
	    exit;
	}
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <!-- Standard Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="OpenTorrentSite: an easy to setup torrent website!">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Soumettre un fichier | Monsite</title>

			
		<!-- Main CSS rules -->
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link href="css/custom_submit.css" rel="stylesheet" />

		<!-- Necessary scripts for jQuery and Bootstrap -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" crossorigin="anonymous"></script>
		<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js' crossorigin="anonymous"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>        

        <script src="js/slidingForm.js"></script>

        <!-- Fonts CSS -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="../../css/favicon.png"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
    </head>

    <body>
    	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 810" preserveAspectRatio="xMinYMin slice" aria-hidden="true"><path fill="#efefee" d="M592.66 0c-15 64.092-30.7 125.285-46.598 183.777C634.056 325.56 748.348 550.932 819.642 809.5h419.672C1184.518 593.727 1083.124 290.064 902.637 0H592.66z"></path><path fill="#f6f6f6" d="M545.962 183.777c-53.796 196.576-111.592 361.156-163.49 490.74 11.7 44.494 22.8 89.49 33.1 134.883h404.07c-71.294-258.468-185.586-483.84-273.68-625.623z"></path><path fill="#f7f7f7" d="M153.89 0c74.094 180.678 161.088 417.448 228.483 674.517C449.67 506.337 527.063 279.465 592.56 0H153.89z"></path><path fill="#fbfbfc" d="M153.89 0H0v809.5h415.57C345.477 500.938 240.884 211.874 153.89 0z"></path><path fill="#ebebec" d="M1144.22 501.538c52.596-134.583 101.492-290.964 134.09-463.343 1.2-6.1 2.3-12.298 3.4-18.497 0-.2.1-.4.1-.6 1.1-6.3 2.3-12.7 3.4-19.098H902.536c105.293 169.28 183.688 343.158 241.684 501.638v-.1z"></path><path fill="#e1e1e1" d="M1285.31 0c-2.2 12.798-4.5 25.597-6.9 38.195C1321.507 86.39 1379.603 158.98 1440 257.168V0h-154.69z"></path><path fill="#e7e7e7" d="M1278.31,38.196C1245.81,209.874 1197.22,365.556 1144.82,499.838L1144.82,503.638C1185.82,615.924 1216.41,720.211 1239.11,809.6L1439.7,810L1439.7,256.768C1379.4,158.78 1321.41,86.288 1278.31,38.195L1278.31,38.196z"></path></svg>

        <!-- Page Content -->
        <div id="submitContainer" class="container">

            <!-- Login -->
            <!-- MultiStep Form -->
			<div class="row">
			    <div class="col-md-6 col-md-offset-3">
			        <form id="msform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
			            <!-- progressbar -->
			            <ul id="progressbar">
			                <li class="active">Avant-garde</li>
			                <li>Liens et hash</li>
			                <li>Description du contenu</li>
			            </ul>
			            <!-- fieldsets -->
			            <fieldset>
			                <h2 class="fs-title">Avant-garde</h2>
			                <h3 class="fs-subtitle">Félicitations, vous êtes sur le point de partager quelque chose d'important avec le monde entier!</h3>

			                <h3 class="fs-subtitle">Avant de continuer, assurez-vous juste de ne rien soumettre de trop personnel, à moins d'être sûr(e) de ce que vous faîtes! </h3>

			                <h3 class="fs-subtitle">Attention: Monsite n'a pas pour but de partager vos fichiers personnels, assurez-vous de partager des fichiers susceptibles d'intéresser d'autres personnes.</h3>

			                <input type="button" name="next" class="next action-button" value="Suivant"/>
			            </fieldset>
			            <fieldset>
			                <h2 class="fs-title">Liens et hash</h2>
			                <h3 class="fs-subtitle">Quels sont les fichiers à référencer?</h3>
			                <input type="text" name="title" placeholder="Nom du fichier/dossier à référencer sur Monsite (requis)" required id="req1" maxlength="60" autofocus/>
			                <input type="text" name="ipfs_hash" placeholder="Hash IPFS (requis)" id="req2"  maxlength="100"/>
			                <input type="text" name="http_mirror" placeholder="Mirroir vers un site HTTP (optionnel)"  maxlength="255"/>
			                <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
			                <input type="button" name="next" class="next action-button" value="Suivant" id="but1" disabled/>
			            </fieldset>
			            <fieldset>
			                <h2 class="fs-title">Description des fichiers</h2>
			                <h3 class="fs-subtitle">Une courte description permet de mieux renseigner les internautes</h3>
			                <input type="text" name="short_desc" placeholder="Description"  maxlength="60"/>
			                <a href="javascript:void(0)" id="showLongDescField">Renseigner une description longue</a>
			                <textarea type="text" name="long_desc" placeholder="Description longue, ce champ accepte le Markdown" class="hiddenField" style="display: none"  maxlength="5000"></textarea>
			                <br />
			                <select class="form-control" name="cat">
			                	<option value="">-- Catégorie (requis)</option>
			                	<option value="1">Films</option>
			                	<option value="2">Séries</option>
			                	<option value="3">Musique</option>
			                	<option value="4">Jeux</option>
			                	<option value="5">Logiciels</option>
			                	<option value="6">Anime</option>
			                	<option value="7">Livres</option>
			                	<option value="8">XXX</option>
			                	<option value="9">Autres</option>	
			                </select>
			                <select class="form-control" name="subcat" disabled>
			                	<option value="">-- Sous-catégorie (requis)</option>
			                </select>
			                <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
			                <input type="submit" class="submit action-button" value="Confirmer l'envoi" disabled/>
			            </fieldset>
			        </form>
			        <div id="errorDiv" class="alert alert-danger" style="display: none;">
			        	Une erreur s'est produite lors du traitement de votre requête. Si vous n'avez pas modifié le contenu de cette page web, vous nous rendriez un grand service en signalant votre problème sur <a href="#">la page Github du site</a>. mettre un lien ici bordel ça traine.
			        	<br />
			        	<br />
			        	There was an error processing your request. If you did not try to modify the content of this webpage, please <a href="#">report the issue on Github</a>. 
			        	<br />
			        	TODO ADD A LINK TO REPO HERE
			        </div>
			        <!-- Do something clean when putting an img for branding -->
			        <a href="./" style="margin: 25px 0;display: inline-block;text-align: center;width: 100%;">MonLogo</a>
			    </div>
			</div>
			<!-- /.MultiStep Form -->
        </div>
        <!-- /.container -->

        <!-- Validator -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>


        <!-- Submit handling -->
        <?php
            include_once "parts/action_submit.php";

            if (!empty($_POST['title']) && !empty($_POST['ipfs_hash']) && !empty($_POST['cat']) && !empty($_POST['subcat'])) {
                submit();
                $_POST = array();
            }
            //We should not bother giving error messages to script kiddies. Regular users should have filled all those
            //fields at this point, because of client side validation.
        ?>

    </body>
</html>
