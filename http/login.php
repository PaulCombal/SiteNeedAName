<?php
ob_start();
session_start();

    // Include plugin.
    //include_once "../../plugins/private_signup_plugin.php";

    // Redirect if the user is already logged in.
if(!empty($_SESSION["username"])) {
    header("Location: ../../index.php");
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

        <title>Login | Monsite</title>

        <?php include "parts/general_head_includes.php"; ?>

        <link href="css/custom_registerlogin.css" rel="stylesheet" />

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
        <div id="loginContainer" class="container">

            <!-- Login -->
            <div id="loginRow" class="row">
                <a href="index.php">Minilogo</a>
                
                <div id="loginTitles">
                    <h2>Connexion</h2>
                    <h3>Utiliser votre compte Monsite</h3>
                </div>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" data-toggle="validator" id="loginform">
                    <div id="feedback" style="display: none;" class="alert alert-danger"></div>
                    <!-- (mail) -->
                    <div class="form-group row">
                        <div>
                            <input name="email" class="form-control" placeholder="Adresse e-mail ou nom d'utilisateur" data-minlength="3" data-error="Veuillez renseigner au moins trois caractères." required />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <!-- (password) -->
                    <div class="form-group row">
                        <div>
                            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Mot de passe Monsite" data-minlength="8" required />
                        </div>
                    </div>

                    <!-- (checkbox) -->
                    <div id="loginCheckbox" class="form-group row">
                        <div>
                            <div class="form-check">
                                <label class="form-check-label checkbox-inline">
                                    <input name="remember" class="form-check-input" type="checkbox"> Se souvenir de moi
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- (submit) -->
                    <div class="form-group row">
                        <div>
                            <button type="submit" class="btn btn-primary">Suivant</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.container -->

        <!-- Validator -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>


        <!-- Login handling -->
        <?php
            include_once "parts/action_login.php";

            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                login();
            }
        ?>

    </body>
</html>
