<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content text-center">
                    <h1 class="logo-name text-center" style="font-size: 120px; margin: 0% !important; padding: 0% !important;">BIDY</h1>
                    <h2 class="font-bold">J'ai oublié mon mot de passe !</h2>

                    <p>Entrer votre adresse email que vous itulisez pour le compte pour reiniatialiser votre mot de passe.</p>

                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" id="resetForm" role="form" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
                                </div><br>
                                <a href="<?= $this->url("gestion", "access", "login"); ?>" class="btn btn-xs btn-outline btn-rounded"><i class="fa fa-arrow-left"></i> Nouvelle connexion</a>
                                <button style="margin-left: 7%;" type="submit" class="btn btn-primary m-b"><i class="fa fa-check"></i> Reiniatialiser le mot de passe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                AMD, tous droits reservés
            </div>
            <div class="col-md-6 text-right">
               <small>© 2019-2020</small>
           </div>
       </div>
   </div>

<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

</body>

</html>
