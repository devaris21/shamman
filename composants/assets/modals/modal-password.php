<div class="modal inmodal fade" id="modal-password">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Changer mot de passe</h4>
            </div>
            <form method="POST" id="formPassword">
                <div class="modal-body">
                    <div class="">
                        <label>Votre mot de passe actuel <span1>*</span1></label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password0" required>
                        </div>
                    </div>
                    <div class="">
                        <label>Nouveau mot de passe <span1>*</span1></label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="">
                        <label>Confirmer le mot de passe <span1>*</span1></label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password1" required>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-danger pull-right"><i class="fa fa-refresh"></i> Changer le mot de passe</button>
                </div>
                    <br>
            </form>
        </div>
    </div>
</div>