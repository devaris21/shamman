
<div class="modal inmodal fade" id="modal-rangement<?= $production->getId() ?>" style="z-index: 99999999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Rangement de la production</h4>
            <small class="font-bold">Renseigner ces champs pour valider la production</small>
        </div>
        
        <form class="formRangement">

            <div class="ibox">
                <div class="ibox-content"><br>
                    <div class="row">
                        <?php foreach ($production->ligneproductionjours as $key => $ligne) {
                            $ligne->actualise(); ?>
                            <div class="col-sm col-md">
                                <label><b><?= $ligne->produit->name() ?></b> eff. rangée <span class="text-muted gras"> / <?= $ligne->production ?></span></label>
                                <input type="number" value="<?= $ligne->production ?>" min=0 max="<?= $ligne->production ?>" number class="gras form-control text-center" name="range-<?= $ligne->produit->getId() ?>">
                            </div>
                        <?php }  ?>
                    </div><hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-uppercase"><u>Personnel pour le rangement</u></h4>
                            <ul>
                                <?php foreach ($productionjour->fourni("manoeuvredujour") as $key => $man) {
                                    $man->actualise(); ?>
                                    <li><?= $man->manoeuvre->name() ?></li>
                                <?php } ?>
                            </ul><hr class="mp3">

                            <b>Le groupe de manoeuvres qui a rangé</b><br>
                            <?php Native\BINDING::html("radio", "groupemanoeuvre", [$productionjour->groupemanoeuvre_id_rangement], "groupemanoeuvre_id_rangement") ?><br><br>

                            <b>Ou definir manuellement les manoeuvres qui ont rangés</b>
                            <?php Native\BINDING::html("select-multiple", "manoeuvre") ?>
                        </div>

                        <div class="col-md-4 offset-md-2">
                            <h4 class="text-uppercase"><u>Ajouter une note</u></h4>
                            <textarea class="form-control" rows="4" name="comment" placeholder="Ajouter une note..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="container">
                <input type="hidden" name="id" value="<?= $production->getId() ?>">
                <button type="button" class="btn btn-sm  btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Annuler</button>
                <button class="btn dim btn-primary pull-right"><i class="fa fa-check"></i> Valider le rangement</button>
            </div>
            <br>
        </form>
    </div>


</div>
</div>


