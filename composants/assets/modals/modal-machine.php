<div class="modal inmodal fade" id="modal-machine" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire de machine</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer la machine</small>
            </div>
            <form method="POST" class="formShamman" classname="machine">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nom de la machine </label>
                            <div class="form-group">
                                <input type="text" class="form-control input-xs" name="name" required placeholder="Machine de BTC">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>La marque </label>
                            <div class="form-group">
                                <input type="text" class="form-control input-xs" name="marque" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Le modèle du machine</label>
                            <div class="form-group">
                                <input type="text" class="form-control input-xs" name="modele">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Image de la machine</label>
                            <div class="">
                                <img style="width: 80px;" src="" class="img-thumbnail logo">
                                <input class="hide" type="file" name="image">
                                <button type="button" class="btn btn-sm bg-orange pull-right btn_image"><i class="fa fa-image"></i> Ajouter une image</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-white" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>