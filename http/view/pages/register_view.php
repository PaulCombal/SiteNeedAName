<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Rejoindre la communauté IPFS France">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>S'inscrire | IPFS France</title>

    <?php include "view/general_head_includes.php"; ?>
    <link href="../public/css/custom_registerlogin.css" rel="stylesheet">

    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    
    <!-- Favicon
    <link rel="shortcut icon" type="image/png" href="../../css/favicon.png"/>-->
</head>

<body>
    <?php 
        include "view/header_template.php";
    ?>

    <h1>Créer votre compte Monsite</h1>
    <!-- Page Content -->
    <div class="container">

        <!-- Login -->
        <div class="row">
            <div class="col-md-7">
                <h3>Internet, libre</h3>
                <span class="subdesc">IPFS, un réseau de réseau alternatif dont nous somme tous piliers</span>

                <br><br>Placer ici des petites images ou icônes colorées<br><br><br>

                <h3>La 1ère communauté française</h3>
                <span class="subdesc">Monsite est la plateforme la plus populaire de partage de fichiers 100% peer-to-peer</span>

                <br><br>

                <img src="../public/images/register/ipfs-logo-text-250x100-ice.png" alt="IPFS logo 250x100"/>

            </div>

            <div class="col-md-5">
                <form method="POST" action="<?= $base ?>register" data-toggle="validator" id="form">
                    <div id="feedback" style="display: none;" class="alert alert-danger"></div>

                    <!-- (username) -->
                    <div class="form-group row">
                      <label for="inputUsername" class="col-sm-2 col-form-label">Choisissez votre nom d'utilisateur</label><br />
                      <div class="col-sm-10">
                        <input name="username" type="text" class="form-control" id="inputUsername" placeholder="Votre nom d'utilisateur Monsite" data-minlength="4" data-error="Votre nom doit avoir plus de 4 lettres!" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (mail) -->
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">E-mail</label>
                      <div class="col-sm-10">
                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Votre adresse e-mail" data-error="Mauvais format d'adresse mail" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (password) -->
                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-2 col-form-label">Mot de passe</label>
                      <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe Monsite" data-minlength="8" required>
                        <div class="help-block">8 caractères minimum</div>
                      </div>
                    </div>

                    <!-- (passwordToValidate) -->
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Confirmation mot de passe</label>
                      <div class="col-sm-10">
                        <input name="tovalidatepassword" type="password" class="form-control" id="inputPassword" placeholder="Répéter le mot de passe" data-match="#inputPassword3" data-match-error="Les mots de passe ne correspondent pas.." data-minlength="8" data-error="Mot de passe trop court" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (checkbox) -->
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input name="remember" class="form-check-input" type="checkbox" data-error="Please accept our terms" required> J'ai lu et j'accepte <a href="#">les CGU</a>
                          </label>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                    </div>

                    <!-- (submit) -->
                    <div class="form-group row">
                    <label class="col-sm-2"></label>
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Créer mon compte</button>
                      </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Validator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

</body>
</html>