<div class="modal inmodal fade" id="modal-params">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Informations générales</h4>
            </div>
            <form method="POST" class="formShamman" classname="params">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Raison sociale </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="societe" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Email </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label>Situation géographiques </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="adresse" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Contacts </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Fax </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="fax">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label>Boîte postale </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="postale">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Devise </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="devise" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Votre logo</label>
                            <div class="">
                                <img style="width: 80px;" src="" class="img-thumbnail logo">
                                <input class="hide" type="file" name="image">
                                <button type="button" class="btn btn-sm bg-purple pull-right btn_image"><i class="fa fa-image"></i> Ajouter une image</button>
                            </div>
                        </div>
                    </div>

                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-primary pull-right dim"><i class="fa fa-check"></i> mettre à jour les infos</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
