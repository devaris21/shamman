
<div class="modal inmodal fade" id="modal-groupecommande" style="z-index: -9">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-3">
                                    <img style="width: 120%" src="<?= $rooter->stockage("images", "societe", $params->image) ?>">
                                </div>
                                <div class="col-9">
                                    <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                    <h5 class="mp0"><?= $params->postale ?></h5>
                                    <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                    <h5 class="mp0">Email: <?= $params->email ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 text-right">
                            <h2 class="title text-uppercase gras">Fiche de commande</h2>
                            <h3 class="text-uppercase"><?= $groupecommande->client->name()  ?> // <span style="font-weight: normal;"><?= $groupecommande->client->typeclient->name()  ?></span></h3>
                            <h5><?= $groupecommande->client->contact  ?> // <?= $groupecommande->client->email  ?></h5>
                        </div>
                    </div><hr>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3"></th>
                                <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                    <th class="text-center"><?= $produit->name() ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $datas1 = $groupecommande->fourni("commande", ["etat_id !="=>Home\ETAT::ANNULEE]);
                            foreach ($datas1 as $key => $ligne) {
                                $ligne->fourni("lignecommande");
                                $ligne->type = "commande";
                            }
                            $datas2 = $groupecommande->fourni("livraison", ["etat_id !="=>Home\ETAT::ANNULEE]);
                            foreach ($datas2 as $key => $ligne) {
                                $ligne->fourni("lignelivraison");
                                $ligne->type= "livraison";
                            }
                            $datas = array_merge($datas1, $datas2);
                            usort($datas, "comparerDateCreated");

                            foreach ($datas as $key => $ligne) { ?>
                                <tr>
                                    <td data-toggle="tooltip" title="Annuler / Supprimer">
                                        <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                            <?php if ($ligne->type == "commande") { ?>
                                                <i class="fa fa-close fa-3x d-block text-red cursor" onclick="annulerCommande(<?= $ligne->getId() ?>)"></i>
                                            <?php }else if($ligne->type == "livraison" && $ligne->etat_id == Home\ETAT::ENCOURS){ ?> 
                                                <i class="fa fa-close fa-3x d-block text-red cursor" onclick="annulerLivraison(<?= $ligne->getId() ?>)"></i>
                                            <?php } ?> 
                                        <?php } ?> 
                                    </td>
                                    <td>
                                        <h5 class="text-uppercase mp0"><?= $ligne->type ?> N°<?= $ligne->reference  ?></h5>
                                        <small><?= datelong($ligne->created)  ?></small>
                                    </td>
                                    <td data-toggle="tooltip" title="imprimer le bon de <?= $ligne->type ?>">
                                        <?php if ($ligne->type == "livraison") { ?>
                                            <a target="_blank" href="<?= $rooter->url("gestion", "fiches", "bonlivraison", $ligne->getId()) ?>">
                                                <i class="fa fa-file-text fa-2x d-block"></i></a>
                                            <?php }else{ ?>
                                                <a target="_blank" href="<?= $rooter->url("gestion", "fiches", "boncommande", $ligne->getId()) ?>">
                                                    <i class="d-block fa fa-file-text fa-2x"></i></a>
                                                <?php } ?>                                
                                            </td>
                                            <?php 
                                            foreach (Home\PRODUIT::getAll() as $key => $produit) {
                                                $test = 0;
                                                foreach ($ligne->items as $key => $item) {
                                                    if ($item->produit_id == $produit->getId() ) { 
                                                        $test = $item->quantite;
                                                        if ($ligne->type == "livraison") {
                                                            $test = $item->quantite_livree;
                                                        }
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <td><h3 class="text-<?= ($ligne->type == "livraison")? "orange":"green" ?> text-center"> <?= $test  ?> </h3></td>
                                                <?php
                                            }
                                            ?>

                                            <?php if ($ligne->type == "commande" && $ligne->operation_id != 0) { ?>
                                                <td>
                                                    <h4 class="mp0 text-uppercase" style="margin-top: -1.5%;">T = <?= money($ligne->montant) ?> <?= $params->devise  ?> </h4>
                                                    <small>Avance <?= money($ligne->avance) ?> <?= $params->devise  ?> <small style="font-weight: normal;;" data-toggle="tooltip" title="Payement par <?= $ligne->operation->modepayement->name();  ?>">(<?= $ligne->operation->modepayement->initial;  ?>)</small></small>
                                                </td>
                                                <td data-toggle="tooltip" title="imprimer le facture">
                                                    <a target="_blank" href="<?= $rooter->url("gestion", "fiches", "boncaisse", $ligne->operation_id) ?>"><i class="fa fa-file-text fa-2x d-block"></i></a>
                                                </td>
                                            <?php }  ?>

                                            <?php if ($ligne->type == "livraison" && $ligne->etat_id == Home\ETAT::VALIDEE) { ?>
                                                <td >
                                                    <i class="fa fa-check fa-2x text-green"></i>
                                                </td>
                                            <?php }  ?>
                                        </tr>
                                    <?php }
                                    ?>

                                    <tr style="height: 20px;"></tr>

                                    <tr>
                                        <td colspan="3"><h2 class="text-uppercase text-right">Reste à livrer : </h2></td>
                                        <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                            <td widtd="90" class="text-center"><h2 class="gras"><?= money($groupecommande->reste($produit->getId())) ?></h2></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table><br><hr>

                            <div class="row text-center">
                                <div class="col-md">
                                    <button class="btn btn-primary dim" onclick="fairenewcommande(<?= $groupecommande->getId() ?>)"><i class="fa fa-cart-plus"></i> Faire nouvelle commande</button>
                                </div>

                                <div class=" col-md">
                                    <button class="btn btn-success dim" onclick="newProgrammation(<?= $groupecommande->getId() ?>)"><i class="fa fa-truck"></i> Programmer livraison </button>
                                </div>

                                <div class=" col-md">
                                    <button class="btn btn-warning dim" onclick="newlivraison(<?= $groupecommande->getId()  ?>)"><i class="fa fa-truck"></i> Faire livraison aujourd'hui</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
