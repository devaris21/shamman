<div class="modal inmodal fade" id="modal-paye-tricycle<?= $livraison->getId() ?>">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">La Paye</h4>
            </div>
            <form method="POST" class="formPayeTricycle">
                <div class="modal-body">
                    <div class="">
                        <label>Montant à payer<span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="montant" value="<?= $livraison->reste  ?>" max="<?= $livraison->reste  ?>" required>
                        </div>
                    </div>
                    <div class="">
                        <label>Mode de payement <span1>*</span1></label>
                        <div class="form-group">
                            <?php Native\BINDING::html("select", "modepayement"); ?>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="livraison_id" value="<?= $livraison->getId() ?>">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-danger dim pull-right"><i class="fa fa-money"></i> Faire la paye</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>