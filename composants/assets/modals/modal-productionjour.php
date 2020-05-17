
<div class="modal inmodal fade" id="modal-productionjour" style="z-index: 1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="row">
                        <div class="col-sm-7">
                            <h2 class="title text-uppercase gras text-orange">Fiche de rapport journalier</h2>
                        </div>
                        <div class="col-sm-5 text-right">
                            <h5 class="text-uppercase">Dernière mise à jour: // <span style="font-weight: normal;"><?= $productionjour->employe->name()  ?></span></h5>
                            <h5><?= datelong($productionjour->modified) ?></h5>
                        </div>
                    </div><hr>

                    <form id="formProductionJour" classname="productionjour">
                        <h3 class="text-uppercase"><u>Productions du jour</u></h3>
                        <div class="row">
                            <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                <div class="col-sm col-md">
                                    <label><b><?= $produit->name() ?></b> produite</label>
                                    <input type="number" data-toggle="tooltip" title="Production du jour" value="0" min=0 number class="gras form-control text-center" name="prod-<?= $produit->getId() ?>">
                                    <input type="hidden" value="0" name="perte-<?= $produit->getId() ?>">
                                </div>
                            <?php } ?>
                        </div><br>

                        <h3 class="text-uppercase"><u>Consommation du jour</u></h3>
                        <div class="row">
                            <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                <div class="col-md">
                                    <label class=" text-blue"><?= $ressource->name() ?> (<?= $ressource->abbr ?>) consommé</label>
                                    <input data-toggle="tooltip" title="Quantité consommé aujourd'hui" type="number" value="0" min=0 number class="gras form-control text-center" name="conso-<?= $ressource->getId() ?>">
                                </div>
                            <?php } ?>
                        </div><hr>
                        

                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-uppercase"><u>Personnel du jour</u></h4>
                                <ul>
                                    <?php foreach ($productionjour->fourni("manoeuvredujour") as $key => $man) {
                                        $man->actualise(); ?>
                                        <li><?= $man->manoeuvre->name() ?></li>
                                    <?php } ?>
                                </ul><hr class="mp3">

                                <b>Le groupe de manoeuvres qui travaillent</b><br>
                                <?php Native\BINDING::html("radio", "groupemanoeuvre", [$productionjour->groupemanoeuvre_id]) ?><br><br>

                                <b>Ou definir manuellement les manoeuvres qui travaillent</b>
                                <?php Native\BINDING::html("select-multiple", "manoeuvre") ?>
                            </div>

                            <div class="col-md-4 offset-md-2">
                                <h4 class="text-uppercase"><u>Ajouter une note</u></h4>
                                <textarea class="form-control" rows="4" name="comment" placeholder="Ajouter une note..."></textarea>
                            </div>
                        </div>


                        <div class="">
                            <button class="btn pull-right dim btn-primary" ><i class="fa fa-check"></i> Mettre à jour le rapport</button>
                        </div><br>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
