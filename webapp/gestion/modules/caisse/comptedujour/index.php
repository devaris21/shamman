<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-6">
                <h2 class="text-uppercase">Recapitulatif de la journée</h2>
                <form id="formFiltrer" class="row" method="POST">
                    <div class="col-4">
                        <input type="date" value="<?= $date ?>" name="date" class="form-control">
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-sm btn-primary dim" onclick="filtrer()"><i class="fa fa-eye"></i> Voir</button>
                    </div>
                </form> 
            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <img style="width: 20%" src="<?= $this->stockage("images", "societe", "logo.png") ?>">
                            </div>
                            <div class="col-sm-8 text-right">
                                <h2 class="title text-uppercase gras">Recapitulatif de la journée</h2>
                                <h3>Du <?= datecourt3($date) ?></h3>
                            </div>
                        </div><hr><br>

                        <div class="row">
                            <div class="col-sm-9" style="border-right: 2px solid black">

                             <?php if ($employe->isAutoriser("production")) { ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="text-uppercase text-center">Commandes</h3>
                                        <?php if (count($commandes) > 0) { ?>
                                            <div>
                                                <?php foreach ($commandes as $key => $commande) { 
                                                    $commande->actualise();
                                                    $datas = $commande->fourni("lignecommande"); ?>
                                                    <div class="text-left">
                                                        <h6 class="mp0"><span>Zone de livraison :</span> <span class="text-uppercase"><?= $commande->zonelivraison->name() ?></span></h6>   
                                                        <h6 class="mp0"><span>Lieu de livraison :</span> <span class="text-uppercase"><?= $commande->lieu ?></span></h6>                              
                                                        <h6 class="mp0"><span>Client :</span> <span class="text-uppercase"><?= $commande->groupecommande->client->name() ?></span></h6>
                                                    </div>
                                                    <table class="table table-bordered mp0">
                                                        <thead>
                                                            <tr>
                                                                <?php foreach ($commande->lignecommandes as $key => $ligne) { 
                                                                    if ($ligne->quantite > 0) {
                                                                        $ligne->actualise(); ?>
                                                                        <th class="text-center"><?= $ligne->produit->name() ?></th>
                                                                    <?php }
                                                                } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($commande->lignecommandes as $key => $ligne) {
                                                                    if ($ligne->quantite > 0) { ?>
                                                                        <td class="text-center"><?= $ligne->quantite ?></td>
                                                                    <?php   } 
                                                                } ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span class="mp0 pull-right"><span>Coût :</span> <span class="text-uppercase"><?= money($commande->montant) ?> <?= $params->devise ?></span></span>
                                                    <hr>
                                                <?php } ?>
                                            </div>
                                        <?php }else{ ?>
                                            <p class="text-center text-muted italic">Aucune commande ce jour </p>
                                        <?php } ?>
                                    </div>

                                    <div class="col-sm-6 border-left">
                                        <h3 class="text-uppercase text-center">livraisons</h3>
                                        <?php if (count($livraisons) > 0) { ?>
                                            <div>
                                                <?php foreach ($livraisons as $key => $livraison) { 
                                                    $livraison->actualise();
                                                    $datas = $livraison->fourni("lignelivraison"); ?>
                                                    <div class="text-left">
                                                        <h6 class="mp0"><span>Zone de livraison :</span> <span class="text-uppercase"><?= $livraison->zonelivraison->name() ?></span></h6>   
                                                        <h6 class="mp0"><span>Lieu de livraison :</span> <span class="text-uppercase"><?= $livraison->lieu ?></span></h6>                              
                                                        <h6 class="mp0"><span>Client :</span> <span class="text-uppercase"><?= $livraison->groupecommande->client->name() ?></span></h6>
                                                        <h6 class="mp0"><span>Chauffeur :</span> <span class="text-uppercase"><?= $livraison->chauffeur->name() ?></span></h6>
                                                    </div>
                                                    <table class="table table-bordered mp0">
                                                        <thead>
                                                            <tr>
                                                                <?php foreach ($livraison->lignelivraisons as $key => $ligne) { 
                                                                    if ($ligne->quantite > 0) {
                                                                        $ligne->actualise(); ?>
                                                                        <th colspan="2" class="text-center"><?= $ligne->produit->name() ?></th>
                                                                    <?php }
                                                                } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($livraison->lignelivraisons as $key => $ligne) {
                                                                    if ($ligne->quantite > 0) { ?>
                                                                       <td data-toogle="tooltip" title="effectivement livré" class="text-center text-green"><?= $ligne->quantite_livree ?></td>
                                                                       <td data-toogle="tooltip" title="perte" class="text-center text-red"><?= $ligne->quantite - $ligne->quantite_livree  ?></td>
                                                                   <?php   } 
                                                               } ?>
                                                           </tr>
                                                       </tbody>
                                                   </table>
                                                   <h6 class="mp0 pull-right"><span>Véhicule :</span> <span class="text-uppercase"><?= $livraison->vehicule->name() ?></span></h6>
                                                   <hr>
                                               <?php } ?>
                                           </div>
                                       <?php }else{ ?>
                                        <p class="text-center text-muted italic">Aucune livraison ce jour </p>
                                    <?php } ?>
                                </div>
                            </div> <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-uppercase text-center">production</h3>
                                    <table class="table table-bordered mp0">
                                        <thead>
                                            <tr>
                                                <?php foreach (Home\PRODUIT::getAll() as $key => $produit) {  ?>
                                                    <th colspan="2" class="text-center"><?= $produit->name() ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php foreach (Home\PRODUIT::getAll() as $key => $produit) {
                                                    $datas = $produit->fourni("ligneproductionjour", ["DATE(created) = " => $date]);  ?>
                                                    <td data-toogle="tooltip" title="production" class="text-center gras"><?= money(comptage($datas, "production", "somme")) ?></td>
                                                    <td data-toogle="tooltip" title="perte" class="text-center text-red"><?= money(comptage($datas, "perte", "somme")) ?></td>
                                                <?php   }  ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h3 class="text-uppercase text-center">consommation des ressources</h3>
                                    <table class="table table-bordered mp0">
                                        <thead>
                                            <tr>
                                                <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) {  ?>
                                                    <th class="text-center"><?= $ressource->name() ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) {
                                                    $datas = $ressource->fourni("ligneconsommationjour", ["DATE(created) = " => $date]);  ?>
                                                    <td data-toogle="tooltip" title="production" class="text-center"><?= money(comptage($datas, "consommation", "somme")) ?> <?= $ressource->abbr  ?></td>
                                                <?php   }  ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><hr><hr>


                            <br><h3 class="text-uppercase text-center">Approvisionnements</h3><br>
                            <div class="">
                                <?php if (count($approvisionnements) > 0) { ?>
                                    <div class="row">
                                        <?php foreach ($approvisionnements as $key => $approvisionnement) { 
                                            $approvisionnement->actualise();
                                            $datas = $approvisionnement->fourni("ligneapprovisionnement"); ?>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="text-left">
                                                    <h6 class="mp0"><span>Fournisseur :</span> <span class="text-uppercase"><?= $approvisionnement->fournisseur->name() ?></span></h6>                            
                                                    <h6 class="mp0"><span>Etat :</span> <span class="text-uppercase"><?= $approvisionnement->etat->name() ?></span></h6>
                                                </div>
                                                <table class="table table-bordered mp0">
                                                    <thead>
                                                        <tr>
                                                            <?php foreach ($approvisionnement->ligneapprovisionnements as $key => $ligne) { 
                                                                if ($ligne->quantite > 0) {
                                                                    $ligne->actualise(); ?>
                                                                    <th class="text-center"><?= $ligne->ressource->name() ?></th>
                                                                <?php }
                                                            } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <?php foreach ($approvisionnement->ligneapprovisionnements as $key => $ligne) {
                                                                if ($ligne->quantite > 0) { ?>
                                                                    <td class="text-center"><?= $ligne->quantite ?></td>
                                                                <?php   } 
                                                            } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <span class="mp0 pull-right"><span>Coût :</span> <span class="text-uppercase"><?= money($approvisionnement->montant) ?> <?= $params->devise ?></span></span>
                                                <hr>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php }else{ ?>
                                    <p class="text-center text-muted italic">Aucune approvisionnement ce jour </p>
                                <?php } ?>
                            </div>
                            <?php } ?><hr><br>


                            <?php if ($employe->isAutoriser("caisse")) { ?>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover ">
                                            <thead>
                                                <tr class="text-center text-uppercase">
                                                    <th colspan="2" style="visibility: hidden; width: 62%"></th>
                                                    <th>Entrée</th>
                                                    <th>Sortie</th>
                                                    <th>Résultats</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">Repport du solde </td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">-</td>
                                                    <td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , dateAjoute(-1))) ?> <?= $params->devise ?></td>
                                                </tr>
                                                <?php foreach ($operations as $key => $operation) { ?>
                                                    <tr style="font-size: 11px;">
                                                        <td style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $this->url("gestion", "fiches", "boncaisse", $operation->getId())  ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                                        <td>
                                                            <h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?> <span><?= ($operation->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <span class="pull-right"><i class="fa fa-clock-o"></i> <?= heurecourt($operation->created) ?></span></h6>
                                                            <i style="font-size: 11px;"><?= $operation->comment ?></i>
                                                        </td>
                                                        <?php if ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE) { ?>
                                                            <td class="text-center text-green gras" style="padding-top: 12px; font-size: 11px;">
                                                                <?= money($operation->montant) ?> <?= $params->devise ?>
                                                            </td>
                                                            <td class="text-center"> - </td>
                                                        <?php }elseif ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::SORTIE) { ?>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center text-red gras" style="padding-top: 12px; font-size: 11px;">
                                                                <?= money($operation->montant) ?> <?= $params->devise ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php $last += ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)? $operation->montant : -$operation->montant ; ?>
                                                        <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr >
                                                    <td colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes du jour</h4></td>
                                                    <td><h4 class="text-center text-green"><?= money(comptage($entrees, "montant", "somme") + $repport) ?> <?= $params->devise ?></h4></td>
                                                    <td><h4 class="text-center text-red"><?= money(comptage($depenses, "montant", "somme")) ?> <?= $params->devise ?></h4></td>
                                                    <td><h4 class="text-center"><?= money($last) ?> <?= $params->devise ?></h4></td>
                                                </tr>
                                                <tr style="height: 15px;"></tr>
                                                <tr>
                                                    <td colspan="2"><h4 class="text-uppercase mp0 text-right">Solde du compte au <?= datecourt(dateAjoute()) ?></h4></td>
                                                    <td colspan="3"><h2 class="text-center"><?= money($last) ?> <?= $params->devise ?></h2></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>


                        </div>
                        <div class="col-sm-3 text-right">
                            <h4 class="text-uppercase">Employés connectés</h4>
                            <ul>
                                <?php foreach ($employes as $key => $emp) { 
                                    $emp->actualise();  ?>
                                    <li><?= $emp->name(); ?></li>
                                <?php } ?>
                            </ul><br>
                            <hr>

                            <h4 class="text-uppercase">Groupe de manoeuvres</h4>
                            <h6><?= $productionjour->groupemanoeuvre->name(); ?></h6>
                            <ul>
                                <?php foreach ($productionjour->fourni("manoeuvredujour") as $key => $man) { 
                                    $man->actualise(); ?>
                                    <li><?= $man->manoeuvre->name(); ?></li>
                                <?php } ?>
                            </ul><br>
                            <hr>


                            <h4 class="text-uppercase">Coût de la production</h4><br>   

                            <h6 class="text-uppercase">Coût de production</h6>
                            <h3 class="text-info"><?= money($productionjour->total_production); ?> <?= $params->devise ?></h3>

                            <h6 class="text-uppercase">Coût de Rangement</h6>
                            <h3 class="text-blue"><?= money($productionjour->total_rangement); ?> <?= $params->devise ?></h3>

                            <h6 class="text-uppercase">Coût de livraison</h6>
                            <h3 class="text-warning"><?= money($productionjour->total_livraison); ?> <?= $params->devise ?></h3>
                            <hr>


                            <?php if ($employe->isAutoriser("caisse")) { ?>
                                <h4 class="text-uppercase">SOLDE DU COMPTE</h4>
                                <div class="">
                                    <small>Solde en Ouverture</small>
                                    <h2 class="no-margins"><?= money(Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , dateAjoute1($date, -1))) ?> <?= $params->devise ?></h2>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar" style="width: 100%;"></div>
                                    </div>
                                </div><br>

                                <small>Entrées du jour</small>
                                <h3 class="no-margins text-green"><?= money(Home\OPERATION::entree(dateAjoute() , dateAjoute(+1))) ?></h3>
                                <br>

                                <small>Dépenses du jour</small>
                                <h3 class="no-margins text-red"><?= money(Home\OPERATION::sortie(dateAjoute() , dateAjoute(+1))) ?></h3>
                                <br>

                                <div class="">
                                    <small>Solde à la fermeture</small>
                                    <h2 class="no-margins"><?= money(Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , $date)) ?> <?= $params->devise ?></h2>
                                    <div class="progress progress-mini">
                                        <div class="progress-bar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <hr>
                            <?php } ?>
                            <br>

                            <h4 class="text-uppercase">Pannes véhicules/machines</h4>
                            <div>
                                <?php 
                                $datas = array_merge($demandes, $pannes);
                                if (count($datas) > 0) { ?>
                                    <table class="table text-left">
                                        <tbody>
                                            <?php foreach ($demandes as $key => $dem) {
                                                $dem->actualise();
                                                ?>
                                                <tr>    
                                                    <td>
                                                        <img alt="image" style="width: 30px;" class="m-t-xs" src="<?= $this->stockage("images", "vehicules", $dem->vehicule->image) ?>">
                                                    </td>
                                                    <td class="">
                                                        <h5 class="text-uppercase gras"><?= $dem->vehicule->marque->name() ?> <?= $dem->vehicule->modele ?></h5>
                                                        <h6 class=""><?= $dem->vehicule->immatriculation ?></h6>
                                                    </td>  
                                                </tr>
                                            <?php } ?>

                                            <?php foreach ($pannes as $key => $dem) {
                                                $dem->actualise();
                                                ?>
                                                <tr>    
                                                    <td>
                                                        <img alt="image" style="width: 30px;" class="m-t-xs" src="<?= $this->stockage("images", "machines", $dem->machine->image) ?>">
                                                    </td>
                                                    <td class="">
                                                        <h5 class="text-uppercase gras"><?= $dem->machine->name() ?></h5>
                                                        <h6><?= $dem->machine->marque ?> <?= $dem->machine->modele ?></h6>
                                                    </td> 
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>    
                                <?php }else{ ?>
                                    <p class="text-center text-muted">Aucune panne ce jour !</p>
                                <?php } ?>                         
                            </div><br>


                            <h4 class="text-uppercase">les Entretiens </h4>
                            <div>
                                <?php 
                                $datas = array_merge($entretiensv, $entretiensm);
                                if (count($datas) > 0) { ?>
                                    <table class="table text-left">
                                        <tbody>
                                            <?php foreach ($entretiensv as $key => $dem) {
                                                $dem->actualise();
                                                ?>
                                                <tr>    
                                                    <td>
                                                        <img alt="image" style="width: 30px;" class="m-t-xs" src="<?= $this->stockage("images", "vehicules", $dem->vehicule->image) ?>">
                                                    </td>
                                                    <td class="">
                                                        <h5 class="text-uppercase gras"><?= $dem->vehicule->marque->name() ?> <?= $dem->vehicule->modele ?></h5>
                                                        <h6 class=""><?= $dem->vehicule->immatriculation ?></h6>
                                                        <hr class="mp0">
                                                        <small class="">Pres: <b><?= $dem->prestataire->name() ?></b></small><br>
                                                        <small class="">Montant: <b><?= money($dem->price) ?> <?= $params->devise ?></b></small>
                                                    </td>  
                                                </tr>
                                            <?php } ?>

                                            <?php foreach ($entretiensm as $key => $dem) {
                                                $dem->actualise();
                                                ?>
                                                <tr>    
                                                    <td>
                                                        <img alt="image" style="width: 30px;" class="m-t-xs" src="<?= $this->stockage("images", "machines", $dem->machine->image) ?>">
                                                    </td>
                                                    <td class="">
                                                        <h5 class="text-uppercase gras"><?= $dem->machine->name() ?></h5>
                                                        <h6><?= $dem->machine->marque ?> <?= $dem->machine->modele ?></h6>
                                                        <hr class="mp0">
                                                        <small class="">Pres: <b><?= $dem->prestataire->name() ?></b></small><br>
                                                        <small class="">Montant: <b><?= money($dem->price) ?> <?= $params->devise ?></b></small>
                                                    </td> 
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>    
                                <?php }else{ ?>
                                    <p class="text-center text-muted">Aucun entretien ce jour !</p>
                                <?php } ?>                         
                            </div><br>



                            <h4 class="text-uppercase">COMMENTAIRE</h4>
                            <p class="text-justify"><?= $productionjour->comment ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>


</body>

</html>
