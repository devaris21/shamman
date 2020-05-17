
<div class="modal inmodal fade" id="modal-programmation-valider" style="z-index: 99999999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Validation de la livraison</h4>
            <small class="font-bold">Renseigner ces champs pour enregistrer la livraison</small>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les produits de la livraison</h5>
                    </div>
                    <div class="ibox-content"><br>
                        <div class="table-responsive">
                            <table class="table  table-striped">
                                <tbody class="commande">
                                    <?php foreach ($livraison->lignelivraisons as $key => $ligne) {
                                        $ligne->actualise();
                                        $reste = $livraison->groupecommande->reste($ligne->produit->getId()) + $ligne->quantite;
                                        if ($reste > 0) { ?>
                                         <tr class="border-0 border-bottom " id="ligne<?= $ligne->produit->getId() ?>" data-id="<?= $ligne->produit->getId() ?>">
                                            <td><i class="fa fa-close text-red cursor" onclick="supprimeProduit(<?= $ligne->produit->getId() ?>)" style="font-size: 18px;"></i></td>
                                            <td >
                                                <img style="width: 40px" src="<?= $rooter->stockage("images", "produits", $ligne->produit->image) ?>">
                                            </td>
                                            <td class="text-left">
                                                <h4 class="mp0 text-uppercase"><?= $ligne->produit->name() ?></h4>
                                                <small><?= $ligne->produit->description ?></small>
                                            </td>
                                            <td width="105"><input type="number" number class="form-control text-center gras" value="<?= $ligne->quantite ?>" max="<?= $reste ?>"></td>
                                            <td> / <?= $reste ?></td>
                                        </tr>
                                    <?php }   
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4 ">
            <div class="ibox"  style="background-color: #eee">
                <div class="ibox-title" style="padding-right: 2%; padding-left: 3%; ">
                    <h5 class="text-uppercase">Finaliser la livraison</h5>
                </div>
                <div class="ibox-content"  style="background-color: #fafafa">
                    <form id="formValiderLivraisonProgrammee">
                        <div>
                            <label>zone de livraison <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <select class="select2 form-control" name="zonelivraison_id" style="width: 100%">
                                    <?php 
                                    $datas = $livraison->groupecommande->fourni("commande");
                                    $datas2 = $dt = [];
                                    foreach ($datas as $key => $value) {
                                        if (!in_array($value->zonelivraison_id, $dt)) {
                                            $dt[] = $value->zonelivraison_id;
                                            $datas2[] = $datas[$key];
                                        }
                                    }
                                    foreach ($datas2 as $key => $commande) {
                                        $commande->actualise(); ?>
                                        <option value="<?= $commande->zonelivraison_id ?>"><?= $commande->zonelivraison->name()  ?></option>
                                    <?php } ?>                                        
                                </select>
                            </div>
                        </div><br>
                        <div>
                            <label>Lieu de livraison <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span><input type="text" name="lieu" class="form-control" required>
                            </div>
                        </div><br>
                        <div>
                            <label>Véhicule de la livraison <span style="color: red">*</span> </label>                                
                            <div class="input-group">
                                <?php Native\BINDING::html("select-tableau", Home\VEHICULE::ras(), null, "vehicule_id"); ?>
                            </div>
                        </div><br>
                           <div class="chauffeur">
                            <label>Chauffeur de la livraison <span style="color: red">*</span> </label>                                
                            <div class="input-group">
                                <?php Native\BINDING::html("select-tableau", Home\CHAUFFEUR::libres(), null, "chauffeur_id"); ?>
                            </div><br>
                        </div>

                        <div class="location">
                            <label>Location de véhicule <span style="color: red">*</span> </label>  
                            <div class="input-group">
                                <select class="form-control select2" name="isLouer" style="width: 100%">
                                    <option value="0">Non, pas de location de véhicule</option>
                                    <option value="1">Oui, faire louer véhicule</option>
                                </select>
                            </div>
                        </div><br>
                        <div class="montant_location">
                            <label class="gras">Montant de la location <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span><input type="number" number name="montant_location" class="form-control" value="0" min="0">
                            </div><br>
                            <div class="no_modepayement_facultatif">
                                <div>
                                    <label>Montant avancé pour réglement<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span><input type="text" value="0" min="0" name="avance" class="form-control">
                                    </div>
                                </div>
                            </div><br>
                            <div>
                                <label>Mode de payement <span style="color: red">*</span> </label>                                
                                <div class="input-group">
                                    <?php Native\BINDING::html("select", "modepayement"); ?>
                                </div>
                            </div><br>
                            <div class="modepayement_facultatif">
                                <div>
                                    <label>Structure d'encaissement<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-bank"></i></span><input type="text" name="structure" class="form-control">
                                    </div>
                                </div><br>
                                <div>
                                    <label>N° numero dédié<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" name="numero" class="form-control">
                                    </div>
                                </div>
                            </div><br>
                        </div>

                        <div class="tricycle">
                            <div>
                                <label>Nom & prénom du chauffeur tricycle<span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" name="nom_tricycle" class="form-control" >
                                </div>
                            </div><br>
                            <div>
                                <label>Montant à payer au chauffeur tricycle<span style="color: red">*</span> </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span><input type="text" name="paye_tricycle" class="form-control" value="0" min="0" >
                                </div>
                            </div>
                        </div><br>

                        <div>
                            <label><input class="i-checks cursor" type="checkbox" name="chargement_manoeuvre" checked > Chargement par nos manoeuvres</label>
                            <label><input class="i-checks cursor" type="checkbox" name="dechargement_manoeuvre" checked > Déchargement par nos manoeuvres</label>
                        </div><br>
                    </form>
                    <hr/>
                    <button onclick="ValiderLivraisonProgrammee()" class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Valider la livraison</button>
                </div>
            </div>

        </div>
    </div>

</div>
</div>
</div>


