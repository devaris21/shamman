<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">AMB</h1>
            </div>
            <h3>Bienvenue sur la plateforme de gestion AMB</h3>
            <p>Veuillez selecionner la section souhaitée pour vous connecter et commencer sur la plateforme AMB !
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p class="m-t"> <small>AMB, Plateforme de gestion de parc automobile et de flotte &copy; 2020</small> </p>
        </div>
    </div>

       <div class="container text-center">
           <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="widget red-bg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-car fa-4x"></i>
                            <h3 class="m-xs text-uppercase">Gestionnaire AMB</h3><br>
                            <a href="<?= $this->url("gestion", "access", "login") ?>"><button class="btn btn-info dim" type="button"><i class="fa fa-money"></i> Ouvrir la section</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget yellow-bg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-business fa-4x"></i>
                            <h3 class="m-xs text-uppercase">Section Direction</h3><br>
                            <a href="<?= $this->url("direction", "access", "login") ?>"><button class="btn btn-info dim" type="button"><i class="fa fa-money"></i> Ouvrir la section</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget navy-bg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-user fa-4x"></i>
                            <h3 class="m-xs text-uppercase">Section des Carplans</h3><br>
                            <a href="<?= $this->url("carplan", "access", "login") ?>"><button class="btn btn-info dim" type="button"><i class="fa fa-money"></i> Ouvrir la section</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget navy-bg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-gears fa-4x"></i>
                            <h3 class="m-xs text-uppercase">Admin système</h3><br>
                            <a href="<?= $this->url("administration", "access", "login") ?>"><button class="btn btn-info dim" type="button"><i class="fa fa-money"></i> Ouvrir la section</button></a>
                        </div>
                    </div>
                </div>
            </div>
       </div>

    <!-- Mainly scripts -->

    <script type="text/javascript" src="<?= $this->rootPath("composants/dist/js/jquery-3.1.1.min.js") ?>"></script>
    <script type="text/javascript" src="<?= $this->rootPath("composants/dist/js/popper.min.js") ?>"></script>
    <script type="text/javascript" src="<?= $this->rootPath("composants/dist/js/bootstrap.js") ?>"></script>


</body>

</html>
