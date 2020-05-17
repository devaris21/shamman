<div class="modal inmodal fade" id="modal-login">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Changer votre login</h4>
            </div>
            <form method="POST" id="formLogin">
                <div class="modal-body">
                    <div class="">
                        <label>Votre nouveau login<span1>*</span1></label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="login" required>
                        </div>
                    </div>
                    <div class="">
                        <label>Mot de passe pour confirmer le changement <span1>*</span1></label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                </div><hr>
                <div class="container">
                    <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                    <button class="btn btn-sm btn-danger pull-right"><i class="fa fa-refresh"></i> Changer mon login</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
