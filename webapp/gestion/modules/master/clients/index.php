<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-md-7">
                <h2>Liste des clients</h2>
                 <button data-toggle="modal" data-target="#modal-client" class="btn btn-primary dim"><i class="fa fa-plus"></i> Ajouter un client</button>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="widget style1 lazur-bg">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <span> Tous les clients </span>
                                    <h2 class="font-bold"><?= start0(count($clients))  ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget style1 yellow-bg">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <span> Ajoutés cette semaine</span>
                                    <h2 class="font-bold"><?= start0(count(Home\CLIENT::getSemaine()))  ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <?php if (count($clients) > 0) { ?>
           <div class="row">
            <?php foreach ($clients as $key => $client) { ?>
                <div class="col-lg-3 clients">
                    <div class="contact-box ">
                        <a href="<?= $this->url("gestion", "master", "client", $client->getId()) ?>">
                            <h3><strong><?= $client->name() ?></strong></h3>
                            <address>
                                <i class="fa fa-phone"></i>&nbsp; <?= $client->contact ?><br>
                                <i class="fa fa-map-marker"></i>&nbsp; <?= $client->adresse ?><br>
                                <i class="fa fa-envelope"></i>&nbsp; <?= $client->email ?>
                            </address>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }else{ ?>
        <div class="text-center">
            <h1 style="margin-top: 10%;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Vous n'avez pas encore inscrit de client !</h1>
            <button data-toggle="modal" data-target="#modal-client" class="btn btn-primary dim"><i class="fa fa-plus"></i> Ajouter un client</button>
        </div>
    <?php } ?>

</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>
 <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?>  

</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

<?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?>  

</body>

</html>
