<div class="modal inmodal fade" id="modal-client">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Formulaire de la clientèle</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="client">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <label>Type de client <span1>*</span1></label>
                            <div class="form-group">
                                <?php Native\BINDING::html("select", "typeclient"); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label>Nom & prénoms de client <span1>*</span1></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <label>Contact </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact" >
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label>Situation géographique </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="adresse" >
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label>Email </label>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" >
                            </div>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider le formulaire</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>