<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6">

                <h2 class="font-bold text-uppercase"><i class="fa fa-shield"></i> espace de connexion</h2>
                <br>
                <p>Veuillez entrer vos informations de connexion pour avoir accès à la plateforme de gestion.</p>

                <p>En cas d'oubli ou de perte de votre mot de passe, vous pouvez le recupérer à l'aide de votre email en cliquant sur <br><a href="<?= $this->url("gestion", "access", "reset") ?>">J'ai oublié mon mot de passe !</a>
                </p>

                <p>Pour tous autre chose, veuillez contacter votre administrateur système.</p>


            </div>
            <div class="col-md-6">
                <div class="ibox-content text-center">
                    <img style="width: 80px" src="<?= $this->stockage("images", "societe", "logo.png") ?>">
                    <h1 class="logo-name text-center" style="font-size: 90px; letter-spacing: 5px; margin: 0% !important; padding: 0% !important;">BRIXS</h1>
                    <form method="POST" class="m-t" role="form" id="formConnexion" >
                        <div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="identifiant" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="mot de passe" required>
                        </div><br>
                        <button type="submit" class="btn btn-primary block full-width m-b dim"><i class="fa fa-check"></i> Se connecter</button>

                        <!-- <br><p class="text-center"><a href="<?= $this->url("gestion", "access", "reset") ?>">
                            J'ai oublié mon mot de passe !
                        </a></p> --><br>
                        <p>Si vous avez oublié votre mot de passe, veuillez contactez votre administrateur pour qu'il le reinitialise !</p>
                    </form>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                &copy; DEVARIS 21, tous droits reservés
            </div>
            <div class="col-md-6 text-right">
               <small>© 2019-2020</small>
           </div>
       </div>
   </div>


   <div class="modal inmodal" id="modal-newUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Prémière connexion</h4>
            </div>
            <form id="formNewUser" method="post">
                <div class="modal-body">                
                    <p class="text-center">Bienvenue sur votre espace d'administration.<br> Pour plus de sécurité, vous devez changer vos paramètres de connexion pour que vous soyez le seul à les connaitre !</p><br>
                    <div class="form-group">
                        <label>Nouvel identifiant</label>
                        <input type="text" name="login" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="pass0" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Corfirmer mot de passe</label>
                        <input type="password" name="pass" required class="form-control">
                    </div>
                </div>
                <div class="">
                    <br>
                    <div class="container">
                        <button type="button" class="btn btn-default dim pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                        <button class="btn btn-primary dim pull-right"><i class="fa fa-check"></i> Je suis prêt !</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

</body>

</html>
