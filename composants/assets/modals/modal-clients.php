<div class="modal inmodal fade" id="modal-clients">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Liste de vos clients</h4>
                <small class="font-bold">Selectionner le client concerné pour la commande</small>
                <div class="offset-md-4 col-md-4">
                    <input type="text" id="search" class="form-control text-center" placeholder="Rechercher le client"> 
             </div>
         </div>
         <div class="modal-body">
            <div class="row">
              <?php foreach (Home\CLIENT::findBy(["visibility ="=>1]) as $key => $client) { ?>
                <div class="col-md-3 clients">
                    <div class="contact-box" style="padding: 1% 2%">
                        <a href="<?= $this->url("gestion", "master", "client", $client->getId()) ?>">
                            <h4><strong><?= $client->name() ?></strong></h4>
                            <address>
                                <i class="fa fa-phone"></i>&nbsp; <?= $client->contact ?><br>
                                <i class="fa fa-map-marker"></i>&nbsp; <?= $client->adresse ?><br>
                                <i class="fa fa-envelope"></i>&nbsp; <?= $client->email ?>
                            </address>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="container text-center">
        <span>Si le client n'existe pas, alors ajoutez-le !</span><br>
        <button class="btn btn-success dim" data-toggle="modal" data-target="#modal-client"><i class="fa fa-plus"></i> Ajouter un nouveau client</button>
    </div>
</div>
</div>
</div>
