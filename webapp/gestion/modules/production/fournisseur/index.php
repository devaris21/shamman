<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-sm-8">
                    <div class="ibox">
                        <div class="ibox-content">
                            <p></p>
                            <div class="">                                
                               <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Approvision. en cours</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-file-text-o"></i> Flux d'approvisionnements</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-money"></i> Transactions de caisse</a></li>
                            </ul>
                            <div class="tab-content" style="min-height: 300px;">



                               <?php if ($employe->isAutoriser("production")) { ?>

                                <div id="tab-1" class="tab-pane active"><br>
                                    <div class="row container-fluid">
                                        <button type="button" data-toggle=modal data-target='#modal-approvisionnement_' class="btn btn-warning btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvel approvisionnement </button>
                                    </div>
                                    <div class="">
                                        <?php if (count($approvisionnements) > 0) { ?>

                                            <?php foreach ($approvisionnements as $key => $appro) {
                                                $appro->actualise(); 
                                                $appro->fourni("ligneapprovisionnement");
                                                ?>
                                                <h4 class="text-uppercase gras">Commande du <?= datecourt($appro->created)  ?></h4>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <?php foreach ($appro->ligneapprovisionnements as $key => $ligne){
                                                                $ligne->actualise(); ?>
                                                                <th class="text-center"><?= $ligne->ressource->name() ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><h3 class="text-uppercase">A livrer : </h3></td>
                                                            <?php foreach ($appro->ligneapprovisionnements as $key => $ligne) { ?>
                                                                <td class="text-center" style="font-size: 20px;"><?= start0($ligne->quantite_recu) ?></td>
                                                            <?php  }  ?>
                                                            <td class="text-center">
                                                                <button onclick="terminer(<?= $appro->getId() ?>)" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Valider</button>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                                    <button onclick="annuler(<?= $appro->getId() ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                                                <?php } ?>
                                                            </td>                                                            
                                                        </tr>
                                                    </tbody>
                                                </table><hr>
                                            <?php  }  }else{ ?>
                                                <h2 style="margin-top: 15% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune commande en cours pour ce fournisseur !</h2>
                                            <?php } ?>


                                        </div>
                                    </div>

                                    <div id="tab-2" class="tab-pane">
                                        <div class="ibox-content inspinia-timeline">
                                            <?php foreach ($fournisseur->approvisionnements as $key => $appro) {
                                                $appro->actualise();
                                                $appro->fourni("ligneapprovisionnement"); ?>
                                                <div class="timeline-item">
                                                    <div class="row">
                                                        <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                                                            <i data-toggle="tooltip" tiitle="Imprimer le bon" class="fa fa-file-text"></i>
                                                            <?= heurecourt($appro->created) ?>
                                                            <br/>
                                                            <small class="text-navy"><?= datecourt($appro->created) ?></small>
                                                        </div>
                                                        <div class="col-10 content">
                                                            <p class="m-b-xs text-uppercase">Approvisionnement N°<strong><?= $appro->reference ?></strong></p>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <?php foreach ($appro->items as $key => $ligne) {
                                                                            $ligne->actualise();  ?>
                                                                            <th class="text-center text-uppercase"><?= $ligne->ressource->name() ?></th>
                                                                        <?php } ?>
                                                                        <!-- <th class="text-center mp0" style="background-color: transparent; border: none">
                                                                            <?php if ($appro->type == "commande") { ?>
                                                                               <a target="_blank" href="<?= $this->url("gestion", "fiches", "boncommande", $appro->getId())  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de commande</a>
                                                                           <?php }else{ ?>
                                                                            <a target="_blank" href="<?= $this->url("gestion", "fiches", "bonlivraison", $appro->getId())  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de livraison</a>
                                                                        <?php } ?>
                                                                    </th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <?php 
                                                                    foreach ($appro->items as $key => $ligne) { ?>
                                                                        <td><h5 class="text-orange text-center"> <?= start0($ligne->quantite_recu) ?> </h5></td>
                                                                    <?php  } ?>
                                                                    <td>
                                                                        <small>Montant de la commande</small>
                                                                        <h4 class="mp0 text-uppercase" style="margin-top: -1.5%;"><?= money($appro->montant) ?> <?= $params->devise  ?> 
                                                                        <?php if ($appro->operation_id > 0) { ?>
                                                                            <small style="font-weight: normal;;" data-toggle="tooltip" title="Payement par <?= $appro->operation->modepayement->name(); ?>">(<?= $appro->operation->modepayement->initial; ?>)</small>
                                                                        <?php } ?>
                                                                    </h4>
                                                                </td>
                                                                <?php if ($appro->operation_id > 0) { ?>
                                                                 <td class="text-center" data-toggle="tooltip" title="imprimer le facture">
                                                                    <?php if ($employe->isAutoriser("caisse")) { ?>
                                                                        <a target="_blank" href="<?= $this->url("gestion", "fiches", "boncaisse", $appro->operation->getId()) ?>"><i class="fa fa-file-text fa-2x"></i></a>
                                                                    <?php } ?>       
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>                                      
                            </div>

                        </div>
                    <?php } ?>


                    <?php if ($employe->isAutoriser("caisse")) { ?>
                       <div id="tab-3" class="tab-pane"><br>
                        <?php foreach ($fluxcaisse as $key => $transaction) {
                            $transaction->actualise(); ?>
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                                        <i data-toggle="tooltip" tiitle="Imprimer le bon" class="fa fa-file-text"></i>
                                        <?= heurecourt($transaction->created) ?>
                                        <br/>
                                        <small class="text-navy"><?= datecourt($transaction->created) ?></small>
                                    </div>
                                    <div class="col-10 content">
                                        <p>
                                            <span class="">Bon de caisse N°<strong><?= $transaction->reference ?></strong></span>
                                            <span class="pull-right text-right <?= ($transaction->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>">
                                                <span class="gras" style="font-size: 16px"><?= money($transaction->montant) ?> <?= $params->devise ?> <?= ($transaction->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <br>
                                                <small>Par <?= $transaction->modepayement->name() ?></small><br>
                                                <a href="<?= $this->url("gestion", "fiches", "boncaisse", $transaction->getId())  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de caisse</a>
                                            </span>
                                        </p>
                                        <p class="m-b-xs"><?= $transaction->comment ?> </p>
                                        <p class="m-b-xs"><?= $transaction->structure ?> - <?= $transaction->numero ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                 
                    </div>
                <?php } ?>


            </div>

        </div>
    </div>
</div>
</div>

<div class="col-sm-4">
    <div class="ibox selected">

        <div class="ibox-content">
            <div class="tab-content">
                <div id="contact-1" class="tab-pane active">
                    <h2><?= $fournisseur->name() ?> 

                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                        <i onclick="modification('fournisseur', <?= $fournisseur->getId() ?>)" data-toggle="modal" data-target="#modal-fournisseur" class="pull-right fa fa-pencil cursor"></i>
                    <?php } ?>
                </h2>
                <address>
                    <i class="fa fa-phone"></i>&nbsp; <?= $fournisseur->contact ?><br>
                    <i class="fa fa-map-marker"></i>&nbsp; <?= $fournisseur->adresse ?><br>
                    <i class="fa fa-envelope"></i>&nbsp; <?= $fournisseur->email ?>
                </address><hr>

                    <div class="m-b-lg">
                        <span>Acompte actuel chez le fournisseur</span><br>
                        <h2 class="font-bold d-inline"><?= money($fournisseur->acompte) ?> <?= $params->devise  ?></h2> 
                        <button data-toggle="modal" data-target="#modal-acompte-fournisseur" class="cursor simple_tag pull-right"><i class="fa fa-plus"></i> Crediter acompte</button><br><br>

                        <?php if ($fournisseur->acompte > 0) { ?>
                            <button style="font-size: 11px" type="button" data-toggle="modal" data-target="#modal-fournisseur-rembourse" class="btn btn-danger dim btn-block"><i
                                class="fa fa-minus"></i> Se faire rembourser par le fournisseur
                            </button>
                        <?php } ?>

                        <hr>

                        <span>Dette actuelle chez le fournisseur</span><br>
                        <h2 class="font-bold d-inline text-red"><?= money($fournisseur->dette) ?> <?= $params->devise  ?></h2> 
                        <?php if ($fournisseur->dette > 0) { ?>
                            <button data-toggle="modal" data-target="#modal-dette-fournisseur" class="cursor bg-danger simple_tag pull-right text-white"><i class="fa fa-money"></i> Régler la dette</button>
                        <?php } ?>                   

                    </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>
</div>



<?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>

<?php include($this->rootPath("composants/assets/modals/modal-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-acompte-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-dette-fournisseur.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-fournisseur-rembourse.php")); ?>  
<?php include($this->rootPath("composants/assets/modals/modal-approvisionnement_.php")); ?>  

<?php 
foreach ($approvisionnements as $key => $appro) {
   $appro->actualise();
   $appro->fourni("ligneapprovisionnement");
   include($this->rootPath("composants/assets/modals/modal-approvisionnement2.php"));
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../production/approvisionnements/script.js") ?>"></script>


</body>

</html>
