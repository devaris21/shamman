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
                    <h2 class="text-uppercase">Véhicules & machines</h2>
                </div>
                <div class="col-sm-8 cards">
                    <!-- TODO decompte des véhicules -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="ibox text-blue">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Fonctionnels</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row text-center">
                                        <div class="col-sm-6 border-right">
                                            <h2 class="no-margins"><?= start0(count(Home\VEHICULE::ras())); ?></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <h2 class="no-margins"><?= start0(count(Home\MACHINE::ras())); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="ibox text-green">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Panne/réparation</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row text-center">
                                        <div class="col-sm-6 border-right">
                                            <h2 class="no-margins"><?= start0(count(Home\VEHICULE::entretien())); ?></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <h2 class="no-margins"><?= start0(count(Home\MACHINE::entretien())); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="ibox text-red">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">En mission</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row text-center">
                                        <div class="col-sm-6 border-right">
                                            <h2 class="no-margins"><?= start0(count(Home\VEHICULE::mission())); ?></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <h2 class="no-margins"><?= start0(count(Home\MACHINE::mission())); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-content" id="autos">
                <div class="row">
                    <div class="col-md-8">
                        <div class="ibox" >
                            <div class="ibox-title">
                                <h5 class="text-uppercase"><i class="fa fa-car"></i> Tous les véhicules </h5>
                                <div class="ibox-tools">
                                   <!--  <button data-toggle="modal" data-target="#modal-vehicule" style="margin-top: -5%" class="btn btn-primary btn-xs dim"><i class="fa fa-plus"></i> Nouveau véhicule</button> -->
                               </div>
                           </div>
                           <div class="ibox-content table-responsive" style="min-height: 300px;">
                              <?php if (count($vehicules) > 0) { ?>
                                <table class="table table-striped tableCarplan">
                                    <tbody>
                                        <?php foreach ($vehicules as $key => $vehicule) {
                                            $vehicule->actualise();
                                            ?>
                                            <tr class="mp0 <?= ($vehicule->etatvehicule_id == 0)?'encours':'' ?> border-bottom" >    
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
                                                <td class="project-status text-right">
                                                    <span class=" label label-<?= $vehicule->etatvehicule->class ?>"><?= $vehicule->etatvehicule->name ?></span><br>
                                                    <?php if ($vehicule->etatvehicule_id == Home\ETATVEHICULE::RAS) { ?>
                                                        <button onclick="session('vehicule_id', <?= $vehicule->getId() ?>)" data-toggle="modal" data-target="#modal-demandeentretien" class="btn btn-xs btn-warning"><i class="fa fa-car"></i> Déclarer un sinistre</button>
                                                    <?php } ?>
                                                </td>      

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>    
                            <?php }else{ ?>
                                <h1 style="margin-top: 6%;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-2x"></i> <br> Aucun véhicule enregistré pour le moment!</h1>
                            <?php } ?>                         
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="ibox" >
                        <div class="ibox-title">
                            <h5 class="text-uppercase"><i class="fa fa-steam"></i> les machines </h5>
                            <div class="ibox-tools">
                                <!-- <button data-toggle="modal" data-target="#modal-machine" style="margin-top: -5%" class="btn btn-success btn-xs dim"><i class="fa fa-plus"></i> Nouvelle machine</button> -->
                            </div>
                        </div>
                        <div class="ibox-content table-responsive" style="min-height: 300px;">
                           <?php if (count($machines) > 0) { ?>
                            <table class="table table-striped tableCarplan">
                                <tbody>
                                    <?php foreach ($machines as $key => $machine) {
                                        $machine->actualise();
                                        ?>
                                        <tr class="mp0 <?= ($machine->etatvehicule_id == 0)?'encours':'' ?> border-bottom" >    
                                            <td>
                                                <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "machines", $machine->image) ?>">
                                            </td>
                                            <td class="">
                                                <h5 class="text-uppercase gras"><?= $machine->name() ?></h5>
                                                <h6 class=""><?= $machine->marque ?> <?= $machine->modele ?></h6>
                                            </td>                                     
                                            <td class="project-status text-right">
                                                <span class=" label label-<?= $machine->etatvehicule->class ?>"><?= $machine->etatvehicule->name ?></span><br>
                                                <?php if ($machine->etatvehicule_id == Home\ETATVEHICULE::RAS) { ?>
                                                    <button class="btn btn-xs btn-warning" onclick="session('machine_id', <?= $machine->getId() ?>)" data-toggle="modal" data-target="#modal-panne"><i class="fa fa-plus"></i> panne</button>
                                                <?php } ?>
                                            </td>      

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table> 
                        <?php }else{ ?>
                            <h2 style="margin-top: 6%;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-2x"></i> <br> Aucune machine enregistré pour le moment!</h2>
                        <?php } ?>                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>

    <?php include($this->rootPath("composants/assets/modals/modal-demandeentretien.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-panne.php")); ?> 
    <?php //include($this->rootPath("composants/assets/modals/modal-vehicule.php")); ?> 
    <?php //include($this->rootPath("composants/assets/modals/modal-machine.php")); ?> 

</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>


</body>

</html>
