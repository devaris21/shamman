
<div class="modal inmodal fade" id="modal-approvisionnement_" style="z-index: 99999999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Nouvel approvisionnement</h4>
            <small class="font-bold">Renseigner ces champs pour enregistrer l'approvisonnement </small>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les produits de la commande</h5>
                    </div>
                    <div class="ibox-content"><br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody class="approvisionnement">
                                    <!-- rempli en Ajax -->
                                </tbody>
                            </table>

                            <div class="text-center">
                                <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                    <button class="btn btn-white dim newressource" data-id="<?= $ressource->getId() ?>" data-toggle="tooltip" title="<?= $ressource->unite ?>"><?= $ressource->name(); ?></button>
                                <?php }  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="ibox"  style="background-color: #eee">
                    <div class="ibox-title" style="padding-right: 2%; padding-left: 3%; ">
                        <h5 class="text-uppercase">Finaliser l'approvisionnement </h5>
                    </div>
                    <div class="ibox-content container-fluid"  style="background-color: #fafafa">
                        <form id="formApprovisionnement" >
                            <div>
                                <label>Etat de l'approvisionnement <span style="color: red">*</span> </label>                                
                                <select class="select2 form-control" name="etat_id" style="width: 100%;">
                                    <option value="<?= Home\ETAT::ENCOURS ?>">Pas encore livré</option>
                                    <option value="<?= Home\ETAT::VALIDEE ?>">Déjà livré</option>
                                </select>
                            </div><hr>
                            <div>
                                <label>Mode de payement <span style="color: red">*</span> </label>                                
                                <div class="input-group">
                                    <?php Native\BINDING::html("select", "modepayement"); ?>
                                </div>
                            </div><br>
                            <div class="no_modepayement_facultatif">
                                <div>
                                    <label>Montant avancé<span style="color: red">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-money"></i></span><input type="text" value="0" min="0" name="avance" class="form-control">
                                    </div>
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
                            </div> 
                            <input type="hidden" name="fournisseur_id" value="<?= $fournisseur->getId() ?>">
                        </form><br>
                        <h2 class="font-bold total text-right total">0 Fcfa</h2>
                        <hr/>
                        <button onclick="validerApprovisionnement()" class="btn btn-warning btn-block dim"><i class="fa fa-check"></i> Valider l'approvisionnement</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>


