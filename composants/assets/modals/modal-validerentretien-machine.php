<div class="modal inmodal fade" id="modal-validerentretien-machine">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Entretien terminé</h4>
            </div>
            <form method="POST" id="formValiderEntretienMachine">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Reste du montant de l'entretien <span1>*</span1></label>
                            <div class="form-group">
                                <input type="number" number class="form-control" name="montant">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Mode de payement <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "modepayement") ?>
                            </div>
                        </div>
                    </div>

                    <div class="row modepayement_facultatif">
                        <div class="col-sm-6">
                            <label>Structure d'encaissement <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span><input type="text" name="structure" class="form-control">
                            </div>
                        </div><br>
                        <div class="col-sm-6">
                            <label>N° numero dédié <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-primary dim pull-right"><i class="fa fa-refresh"></i> Valider</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
