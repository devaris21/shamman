<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2 class="text-uppercase">Configuration de Base</h2>
                </div>
                <div class="col-sm-8">

                </div>
            </div>

            <div class="wrapper wrapper-content" id="autos">
                <div class="animated fadeInRightBig">
                    <div class="ibox" >
                        <div class="ibox-content" style="min-height: 400px;">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class=""><a class="nav-link active" data-toggle="tab" href="#general"><i class="fa fa-info"></i> Infos Générales</a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#metier"><i class="fa fa-th-large"></i> Gestion & Production </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tabpersonnel"><i class="fa fa-male"></i> Personnel & Exte </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tabvehicules"><i class="fa fa-car"></i> Véhicules & Machines </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#optioncaisse"><i class="fa fa-money"></i> Options de caisse </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#admin"><i class="fa fa-gears"></i> Administration </a></li>
                                </ul><br>                               
                                <div class="tab-content">
                                    <div role="tabpanel" id="general" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-8 border-right">
                                                <div class="ibox">
                                                    <div class="ibox-content"><br>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <span class="text-muted">Raison sociale ou nom de la société</span>
                                                                <h2 class="gras text-uppercase text-primary"><?= $params->societe ?></h2>
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Situation Géographique</span>
                                                                <h4><?= $params->adresse ?></h4>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Contacts</span>
                                                                <h4><?= $params->contact ?></h4>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Email</span>
                                                                <h4><?= $params->email ?></h4>
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Boite Postale</span>
                                                                <h4><?= $params->postale ?></h4>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Fax</span>
                                                                <h4><?= $params->fax ?></h4>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <span class="text-muted">Devise</span>
                                                                <h4><?= $params->devise ?></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-sm-6 text-center">
                                                <h4 class="text-muted text-uppercase">Votre logo</h4>
                                                <img style="width: 240px" src="<?= $this->stockage("images", "societe", $params->image)  ?>">
                                            </div>

                                        </div><hr>
                                        <div>
                                            <button onclick="modification('params', <?= $params->getId() ?>)" class="btn btn-primary dim pull-right" data-toggle="modal" data-target="#modal-params"><i class="fa fa-pencil"></i> Modifier les informations</button>
                                        </div><br><br><br>
                                    </div>



                                    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



                                    <div role="tabpanel" id="metier" class="tab-pane">
                                        <div class="row">

                                            <div class="col-sm-6 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Les produits</h5>
                                                        <div class="ibox-tools">
                                                            <a class="btn_modal btn_modal" data-toggle="modal" data-target="#modal-produit">
                                                                <i class="fa fa-plus"></i> Ajouter
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th></th>
                                                                    <th>Libéllé</th>
                                                                    <th>description</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                    $i++; ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td ><img style="width: 40px" src="<?= $this->stockage("images", "produits", $item->image); ?>"></td>
                                                                        <td class="gras"><?= $item->name(); ?></td>
                                                                        <td><?= $item->description; ?></td>
                                                                        <td data-toggle="modal" data-target="#modal-produit" title="modifier le produit" onclick="modification('produit', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                        <td data-toggle="tooltip" title="modifier le produit" onclick="suppressionWithPassword('produit', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Les ressources de production</h5>
                                                        <div class="ibox-tools">
                                                            <a class="btn_modal" data-toggle="modal" data-target="#modal-ressource">
                                                                <i class="fa fa-plus"></i> Ajouter
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th></th>
                                                                    <th>Libéllé</th>
                                                                    <th>Unité</th>
                                                                    <th>Abbr</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                    $i++; ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td ><img style="width: 40px" src="<?= $this->stockage("images", "ressources", $item->image); ?>"></td>
                                                                        <td class="gras"><?= $item->name(); ?></td>
                                                                        <td><?= $item->unite; ?></td>
                                                                        <td><?= $item->abbr; ?></td>
                                                                        <td data-toggle="modal" data-target="#modal-ressource" title="modifier l'élément" onclick="modification('ressource', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                        <td title="supprimer la ressource" onclick="suppressionWithPassword('ressource', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Exigence de production par ressource</h5>
                                                        <div class="ibox-tools">

                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Les produits</th>
                                                                    <?php foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $ressource) {  ?>
                                                                        <td class="gras text-center"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "ressources", $ressource->image); ?>"> <?= $ressource->name(); ?></td>
                                                                    <?php } ?>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $prod) { ?> 
                                                                    <tr>
                                                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $prod->image); ?>"> <?= $prod->name(); ?></td>

                                                                        <?php 
                                                                        foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $ressource) {
                                                                            $item = Home\EXIGENCEPRODUCTION::findBy(["produit_id ="=>$prod->getId(), "ressource_id ="=>$ressource->getId()])[0]; 
                                                                            $item->actualise(); ?>
                                                                            <td class="text-center"><?= money($item->quantite_ressource); ?> <?= $item->ressource->abbr ?> pour <b><?= $item->quantite_produit ?></b></td>
                                                                        <?php } ?>
                                                                        <td><i class="fa fa-pencil cursor" data-toggle="modal" data-target="#modal-exigence<?= $prod->getId() ?>"> </i></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-6 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Paye par production</h5>
                                                        <div class="ibox-tools">
                                                            <a data-toggle="modal" data-target="#modal-paye_produit">
                                                                <i class="fa fa-plus"></i> Modifier les prix
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Production</th>
                                                                    <th>Rangement</th>
                                                                    <th>Livraison</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\PAYE_PRODUIT::findBy() as $key => $item) {
                                                                    $item->actualise() ?>
                                                                    <tr>
                                                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $item->produit->image); ?>"> <?= $item->produit->name(); ?></td>
                                                                        <td><?= money($item->price) ?> <?= $params->devise ?></td>
                                                                        <td><?= money($item->price_rangement) ?> <?= $params->devise ?></td>
                                                                        <td><?= money($item->price_livraison) ?> <?= $params->devise ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-6 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Paye par production <span class="text-red">dimanches & jours fériés</span></h5>
                                                        <div class="ibox-tools">
                                                            <a data-toggle="modal" data-target="#modal-paye_produit_ferie">
                                                                <i class="fa fa-plus"></i> Modifier les prix
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produit</th>
                                                                    <th>Production</th>
                                                                    <th>Rangement</th>
                                                                    <th>Livraison</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\PAYEFERIE_PRODUIT::findBy() as $key => $item) {
                                                                    $item->actualise() ?>
                                                                    <tr>
                                                                        <td class="gras"><img style="width: 30px; margin-right: 2%" src="<?= $this->stockage("images", "produits", $item->produit->image); ?>"> <?= $item->produit->name(); ?></td>
                                                                        <td class="text-red"><?= money($item->price) ?> <?= $params->devise ?></td>
                                                                        <td class="text-red"><?= money($item->price_rangement) ?> <?= $params->devise ?></td>
                                                                        <td class="text-red"><?= money($item->price_livraison) ?> <?= $params->devise ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-4 col-sm-6 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Les zones de livraison</h5>
                                                        <div class="ibox-tools">
                                                            <a class="btn_modal" data-toggle="modal" data-target="#modal-zonelivraison">
                                                                <i class="fa fa-plus"></i> Ajouter
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Libéllé</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\ZONELIVRAISON::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                                    <tr>
                                                                        <td class="gras"><?= $item->name(); ?></td>
                                                                        <td data-toggle="modal" data-target="#modal-zonelivraison" title="modifier la zone de livraison" onclick="modification('zonelivraison', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                        <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('zonelivraison', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-8 bloc">
                                                <div class="ibox border">
                                                    <div class="ibox-title">
                                                        <h5 class="text-uppercase">Prix des produits par zone de livraison</h5>
                                                        <div class="ibox-tools">

                                                        </div>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <?php $i =0; foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $prod) {  ?>
                                                                        <td class="gras text-center"><?= $prod->name(); ?></td>
                                                                    <?php } ?>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i =0; foreach (Home\ZONELIVRAISON::findBy([], [], ["name"=>"ASC"]) as $key => $zone) {
                                                                    $i++; ?>
                                                                    <tr>
                                                                        <td class="gras"><?= $zone->name(); ?></td>
                                                                        <?php $i =0; foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $prod) { 
                                                                            $pz = new Home\PRIX_ZONELIVRAISON();
                                                                            $datas = $prod->fourni("prix_zonelivraison", ["zonelivraison_id ="=>$zone->getId()]);
                                                                            if (count($datas) > 0) {
                                                                                $pz = $datas[0];
                                                                            }
                                                                            ?>
                                                                            <td class="text-center" ><?= money($pz->price); ?> <?= $params->devise ?></td>
                                                                        <?php } ?>
                                                                        <td data-toggle="modal" data-target="#modal-prix<?= $zone->getId() ?>" title="modifier les prix"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



                                    <div role="tabpanel" id="tabpersonnel" class="tab-pane">
                                        <div class="row">

                                         <div class="col-md-4 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Groupe de manoeuvre</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-groupemanoeuvre">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\GROUPEMANOEUVRE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $item->actualise();  ?>
                                                                <tr>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-groupemanoeuvre" title="modifier ce groupe" onclick="modification('groupemanoeuvre', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce groupe" onclick="suppression('groupemanoeuvre', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-8 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Les manoeuvres</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-manoeuvre">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Coordonnées</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\MANOEUVRE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $item->actualise(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "manoeuvres", $item->image) ?>">
                                                                    </td>
                                                                    <td>
                                                                        <span class="gras"><?= $item->name(); ?></span><br>
                                                                        <?= $item->groupemanoeuvre->name() ?>
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-map-marker"></i> <?= $item->adresse  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>  
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#modal-manoeuvre" title="modifier ce manoeuvre" onclick="modification('manoeuvre', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce manoeuvre" onclick="suppression('manoeuvre', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Les chauffeurs</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-chauffeur">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Coordonnées</th>
                                                                <th colspan="2">Salaire Mensuel</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\CHAUFFEUR::findBy(["visibility ="=>1], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "chauffeurs", $item->image) ?>">
                                                                    </td>
                                                                    <td>
                                                                        <span class="gras"><?= $item->name(); ?></span><br>
                                                                        Permis <?= $item->typepermis ?>
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-map-marker"></i> <?= $item->adresse  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>
                                                                    </td>

                                                                    <td><h3 class="gras"><?= money($item->salaire) ?> <?= $params->devise ?></h3></td>
                                                                    <td class="border-right" data-toggle="modal" data-target="#modal-salaire" title="modifier le salaire" onclick="modification('chauffeur', <?= $item->getId() ?>)"><i class="fa fa-refresh text-blue cursor"></i></td>

                                                                    <td data-toggle="modal" data-target="#modal-chauffeur" title="modifier ce chauffeur" onclick="modification('chauffeur', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce chauffeur" onclick="suppression('chauffeur', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Vos fournisseurs de ressources</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-fournisseur">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Adresse</th>
                                                                <th>Coordonnées</th>
                                                                <th>fax</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\FOURNISSEUR::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "fournisseurs", $item->image) ?>">
                                                                    </td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td><i class="fa fa-map-marker"></i> <?= $item->adresse  ?></td>
                                                                    <td>
                                                                        <i class="fa fa-envelope"></i> <?= $item->email  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>  
                                                                    </td>
                                                                    <td><i class="fa fa-fax"></i> <?= $item->fax ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-fournisseur" title="modifier ce fournisseur" onclick="modification('fournisseur', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce fournisseur" onclick="suppression('fournisseur', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Vos prestataires de services</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-manoeuvre">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Adresse</th>
                                                                <th>Coordonnées</th>
                                                                <th>fax</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\PRESTATAIRE::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "prestataires", $item->image) ?>">
                                                                    </td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td><i class="fa fa-map-marker"></i> <?= $item->adresse  ?></td>
                                                                    <td>
                                                                        <i class="fa fa-envelope"></i> <?= $item->email  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>  
                                                                    </td>
                                                                    <td><i class="fa fa-fax"></i> <?= $item->fax ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-prestataire" title="modifier ce prestataire" onclick="modification('prestataire', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce prestataire" onclick="suppression('prestataire', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


                                <div role="tabpanel" id="tabvehicules" class="tab-pane">
                                    <div class="row">

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Type de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-typevehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\TYPEVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-typevehicule" title="modifier l'élément" onclick="modification('typevehicule', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('typevehicule', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Catégorie de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-groupevehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\GROUPEVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-groupevehicule" title="modifier l'élément" onclick="modification('groupevehicule', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('groupevehicule', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Panne de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-typeentretienvehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\TYPEENTRETIENVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-typeentretienvehicule" title="modifier l'élément" onclick="modification('typeentretienvehicule', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('typeentretienvehicule', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-7">
                                            <div class="ibox border" >
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase"><i class="fa fa-car"></i> Tous les véhicules </h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-vehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content table-responsive" style="min-height: 400px;">
                                                    <table class="table table-striped">
                                                       <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Libéllé</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (Home\VEHICULE::findBy(["visibility ="=>1]) as $key => $vehicule) {
                                                            $vehicule->actualise();
                                                            ?>
                                                            <tr>    
                                                                <td>
                                                                    <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "vehicules", $vehicule->image) ?>">
                                                                </td>
                                                                <td class="">
                                                                    <h5 class="text-uppercase gras"><?= $vehicule->marque->name() ?> <?= $vehicule->modele ?></h5>
                                                                    <h6 class=""><?= $vehicule->immatriculation ?></h6>
                                                                </td>
                                                                <td class="">
                                                                    <h5 class="mp0"><?= $vehicule->typevehicule->name() ?></h5>
                                                                    <h5 class="mp0"><?= $vehicule->groupevehicule->name() ?></h5>
                                                                </td>     
                                                                <td data-toggle="modal" data-target="#modal-vehicule" title="modifier l'élément" onclick="modification('vehicule', <?= $vehicule->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                <td title="supprimer l'élément" onclick="suppressionWithPassword('vehicule', <?= $vehicule->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>                             
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-5">
                                        <div class="ibox border" >
                                            <div class="ibox-title">
                                                <h5 class="text-uppercase"><i class="fa fa-steam"></i> les machines </h5>
                                                <div class="ibox-tools">
                                                    <a class="btn_modal" data-toggle="modal" data-target="#modal-machine">
                                                        <i class="fa fa-plus"></i> Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content table-responsive" style="min-height: 400px;">
                                                <table class="table table-striped">
                                                   <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Libéllé</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (Home\MACHINE::getAll() as $key => $machine) {
                                                        $machine->actualise();
                                                        ?>
                                                        <tr>    
                                                            <td>
                                                                <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "machines", $machine->image) ?>">
                                                            </td>
                                                            <td class="">
                                                                <h5 class="text-uppercase gras"><?= $machine->name() ?></h5>
                                                                <h6 class=""><?= $machine->marque ?> <?= $machine->modele ?></h6>
                                                            </td>
                                                            <td data-toggle="modal" data-target="#modal-machine" title="modifier l'élément" onclick="modification('machine', <?= $machine->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer l'élément" onclick="suppression('machine', <?= $machine->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                             
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>



                        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



                        <div role="tabpanel" id="optioncaisse" class="tab-pane">
                            <div class="row">

                                <div class="col-sm-8 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Type d'opération</h5>
                                            <div class="ibox-tools">
                                                <a class="btn_modal" data-toggle="modal" data-target="#modal-categorieoperation">
                                                    <i class="fa fa-plus"></i> Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><i class="fa fa-ticket"></i></th>
                                                        <th>Libéllé</th>
                                                        <th>Type</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i =0; foreach (Home\CATEGORIEOPERATION::findBy([], [], ["typeoperationcaisse_id"=>"ASC", "name"=>"ASC"]) as $key => $item) {
                                                        $item->actualise();
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><div class="border" style="width: 20px; height: 20px; background-color: <?= $item->color ?>"></div></td>
                                                            <td class="gras"><?= $item->name(); ?></td>
                                                            <td class="gras text-<?= ($item->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"green":"red"  ?>"><?= $item->typeoperationcaisse->name(); ?></td>
                                                            <td data-toggle="modal" data-target="#modal-categorieoperation" title="modifier la categorie" onclick="modification('categorieoperation', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer la categorie" onclick="suppressionWithPassword('categorieoperation', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <form method="POST" class="formShamman" classname="params" reload="false">
                                         <!--    <div class="row">
                                                <div class="col-xs-7 gras">Autoriser système de versement en attente</div>
                                                <div class="offset-1"></div>
                                                <div class="col-xs-4">
                                                    <div class="switch">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" name="autoriserVersementAttente" <?= ($params->autoriserVersementAttente == "on")?"checked":""  ?> class="onoffswitch-checkbox" id="example2">
                                                            <label class="onoffswitch-label" for="example2">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-7 gras">Bloquer les dépenses or fonds directs</div>
                                                <div class="offset-1"></div>
                                                <div class="col-xs-4">
                                                    <div class="switch">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" name="bloquerOrfonds" <?= ($params->bloquerOrfonds == "on")?"checked":""  ?> class="onoffswitch-checkbox" id="example1">
                                                            <label class="onoffswitch-label" for="example1">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br> -->

                                            <div class="row">
                                                <div class="col-4">
                                                    <label>% de tva </label>
                                                    <input type="number" number class="form-control" name="tva" value="<?= $params->tva ?>">
                                                </div><br>
                                                <div class="col-8">
                                                    <label>Seuil de tolérance du crédit client </label>
                                                    <input type="number" number class="form-control" name="seuilCredit" value="<?= $params->seuilCredit ?>">
                                                </div>
                                                <div class="col-6">
                                                    <br>
                                                    <input type="hidden" name="id" value="<?= $params->getId() ?>">
                                                    <button class="btn btn-primary dim "><i class="fa fa-check"></i> Mettre à jour</button>
                                                </div>
                                            </div>
                                            <hr>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



                            <div role="tabpanel" id="admin" class="tab-pane">
                              <div class="bloc">
                                <div class="ibox border">
                                    <div class="ibox-title">
                                        <h5 class="text-uppercase">Administrateurs et gerants</h5>
                                        <div class="ibox-tools">
                                            <a class="btn_modal" data-toggle="modal" data-target="#modal-employe">
                                                <i class="fa fa-plus"></i> Ajouter
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                                <?php $i =0; foreach (Home\EMPLOYE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                    $item->actualise();  ?>
                                                    <tr>
                                                        <td>
                                                            <?php if ($item->is_allowed == 1) { ?>
                                                                <span class="label label-success">Actif</span>
                                                            <?php }else{ ?>
                                                                <span class="label label-danger">Bloqué</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td >
                                                            <span class="gras text-uppercase"><?= $item->name() ?></span><br>
                                                            <span> <?= $item->email ?></span><br>
                                                            <span> <?= $item->adresse ?></span><br>
                                                            <span> <?= $item->contact ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($item->is_new == 1) { ?>
                                                                <span class="">Login: <?= $item->login ?></span><br>
                                                                <span class="">Pass: <?= $item->pass ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="" width="400px">
                                                            <?php $datas = $item->fourni("role_employe");
                                                            $lots = [];
                                                            foreach ($datas as $key => $rem) {
                                                                $rem->actualise();
                                                                $lots[] = $rem->role->getId(); ?>
                                                                <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $rem->role_id ?>" class="btn btn-primary btn-xs refuser"><?= $rem->role->name() ?></button>
                                                                <?php } ?><hr class="mp3">

                                                                <?php foreach (Home\ROLE::getAll() as $key => $role) {
                                                                    if (!in_array($role->getId(), $lots)) { ?>
                                                                       <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $role->getId() ?>" class="btn btn-white btn-xs autoriser"><?= $role->name() ?></button>
                                                                   <?php } } ?>                
                                                               </td>
                                                               <td class="text-right">          
                                                                <button onclick="resetPassword('employe', <?= $item->getId() ?>)" class="btn btn-white btn-xs"><i class="fa fa-refresh text-blue"></i> Init. mot de passe</button><br>

                                                                <?php if ($item->is_allowed == 1) { ?>
                                                                    <button onclick="lock('employe', <?= $item->getId() ?>)" class="btn btn-white btn-xs"><i class="fa fa-lock text-orange"></i> Bloquer</button>
                                                                <?php }else{ ?>
                                                                    <button onclick="unlock('employe', <?= $item->getId() ?>)" class="btn btn-white btn-xs"><i class="fa fa-unlock text-green"></i> Débloquer</button>
                                                                <?php } ?>
                                                                <button data-toggle="modal" data-target="#modal-employe" class="btn btn-white btn-xs" onclick="modification('employe', <?= $item->getId() ?>)"><i class="fa fa-pencil"></i></button>
                                                                <button class="btn btn-white btn-xs" onclick="suppressionWithPassword('employe', <?= $item->getId() ?>)"><i class="fa fa-close text-red"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>
    <?php include($this->relativePath("modals.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>


</body>

</html>
