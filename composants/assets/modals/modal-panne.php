<div class="modal inmodal fade" id="modal-panne">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire de declaration de panne</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="panne">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Type de panne <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" required >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Détails de la panne <span1>*</span1></label>
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3"></textarea>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Manoeuvre en cause <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select-startnull", "manoeuvre"); ?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Illustration 1</label>
                            <div class="">
                                <img style="width: 80px;" src="" class="img-thumbnail logo">
                                <input class="hide" type="file" name="photo">
                                <button type="button" class="btn btn-sm bg-orange pull-right btn_image"><i class="fa fa-image"></i> Ajouter une image</button>
                            </div>
                        </div>
                    </div>
                </div><hr class="">
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-primary dim pull-right"><i class="fa fa-check"></i> Valider l'entretien</button>
                </div>
                <br>
            </form>

        </div>
    </div>
</div>

