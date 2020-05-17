<div class="modal inmodal fade" id="modal-rembourser">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-red">Remboursement</h4>
            </div>
            <form method="POST" id="formRembourser">
                <div class="modal-body">
                    <div class="">
                        <label>Montant à débiter sur le compte <span1>*</span1></label>
                        <div class="form-group">
                            <input type="text" number class="form-control" name="montant" required>
                        </div>
                    </div>   
                    <div>
                        <label>Mode de remboursement <span style="color: red">*</span> </label>                                
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
                    </div>   <br>
                    <div>
                        <label>Motif du remboursement</label>
                        <textarea class="form-control" rows="3" name="comment1"></textarea>
                    </div>              
                </div><hr>
                <div class="container">
                    <input type="hidden" name="client_id" value="<?= $client->getId() ?>">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm dim btn-success pull-right"><i class="fa fa-check"></i> Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
