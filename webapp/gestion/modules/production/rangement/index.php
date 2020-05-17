<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-green gras">Rangements de la production</h2>
                <div class="container">
                    <!-- <div class="row">
                        <div class="col-xs-7 gras ">Afficher même les rangements passées</div>
                        <div class="offset-1"></div>
                        <div class="col-xs-4">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" class="onoffswitch-checkbox" id="example1">
                                    <label class="onoffswitch-label" for="example1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-sm-3">
               <div class="row">
                <div class="col-md-12">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-3">
                                <i class="fa fa-th-large fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <span> Rangements de la production </span>
                                <h2 class="font-bold"><?= start0(count(Home\PRODUCTIONJOUR::ranges()))  ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Toutes les productions non rangées</h5>
                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
               <?php if (count($productions) > 0) { ?>
                 <table class="table table-hover table-commande">
                    <tbody>
                        <?php foreach ($productions as $key => $production) {
                            $production->actualise(); 
                            $production->fourni('ligneproductionjour'); 
                            ?>
                            <tr class="<?= ($production->etat_id == Home\ETAT::VALIDEE)?'fini':'' ?> border-bottom">
                                <td class="project-status">
                                    <span class="label label-<?= $production->etat->class ?>"><?= $production->etat->name ?></span>
                                </td>
                                <td class="project-title border-right" style="width: 35%;">
                                    <h3 class="text-uppercase">Production du <?= datecourt3($production->ladate) ?></h3>
                                    <h5 class="text-uppercase text-muted">produite par <span><?= $production->groupemanoeuvre->name() ?></span></h5>
                                    <ul>
                                        <?php foreach ($production->fourni("manoeuvredujour") as $key => $man) {
                                            $man->actualise(); ?>
                                            <li><?= $man->manoeuvre->name() ?></li>
                                        <?php } ?>
                                    </ul>
                                    <hr class="mp3">
                                    <h5 class="text-uppercase text-muted">Rangé le <?= datecourt3($production->dateRangement) ?> par <span><?= $production->groupemanoeuvre_rangement->name() ?></span></h5>
                                    <ul>
                                        <?php foreach ($production->fourni("manoeuvredurangement") as $key => $man) {
                                            $man->actualise(); ?>
                                            <li><?= $man->manoeuvre->name() ?></li>
                                        <?php } ?>
                                    </ul>
                                </td>
                                <td class="border-right">
                                    <h4>Production de ce jour</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <?php foreach ($production->ligneproductionjours as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center"><?= $ligne->produit->name() ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><h4 class="mp0 text-muted">Produite : </h4></td>
                                                <?php foreach ($production->ligneproductionjours as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center " style="color: #ccc"><?= $ligne->production ?></th>
                                                <?php } ?>
                                            </tr>

                                            <?php if ($production->etat_id == Home\ETAT::VALIDEE) { ?>
                                                <tr>
                                                    <td><h4 class="mp0">Rangées : </h4></td>
                                                    <?php foreach ($production->ligneproductionjours as $key => $ligne) { 
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center"><?= $ligne->production - $ligne->perte ?></th>
                                                    <?php } ?>
                                                </tr>

                                                <tr>
                                                    <td><h4 class="mp0 text-red">Perte : </h4></td>
                                                    <?php foreach ($production->ligneproductionjours as $key => $ligne) { 
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center text-red"><?= $ligne->perte ?></th>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                   <?php if ($production->etat_id == Home\ETAT::PARTIEL) { ?>
                                    <br>
                                    <button data-toggle="modal" data-target="#modal-rangement<?= $production->getId() ?>" class="btn btn-block btn-primary btn-sm dim"><i class="fa fa-plus"></i> Faire le rangement </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune production pour le moment</h1>
        <?php } ?>

    </div>
</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?> 

</div>
</div>


    <?php 
    foreach ($productions as $key => $production) {
        if ($production->etat_id == Home\ETAT::PARTIEL) { 
            $production->actualise();
            $production->fourni("ligneproductionjour");
            include($this->rootPath("composants/assets/modals/modal-rangement.php"));
        } 
    } 
    ?>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
