<div class="modal inmodal fade" id="modal-depense">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-red">Opération de dépense</h4>
                <small class="font-bold text-red">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="operation">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Type d'opération <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select-tableau", Home\CATEGORIEOPERATION::depense(), null, "categorieoperation_id"); ?>
                            </div>
                        </div>                       
                    </div><br>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Montant de l'opération <span1>*</span1></label>
                            <div class="form-group">
                                <input type="number" number class="form-control" name="montant" required>
                            </div>
                        </div>   
                        <div class="col-sm-6">
                            <label>Mode de payement</label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "modepayement"); ?>
                            </div>
                        </div>                     
                    </div>

                    <div class="modepayement_facultatif row">
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
                    </div><br>

                     <div class="row">
                        <div class="col-sm-12">
                            <label>Plus de détails sur l'opération <span1>*</span1></label>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" name="comment"></textarea>
                            </div>
                        </div>                    
                    </div>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>