<div class="modal inmodal fade" id="modal-prixparzone">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Différents prix par zone de livraison</h4>
                <small class="font-bold">Rechercher la zone pour les afficher les différents prix</small>
                <div class="offset-md-4 col-md-4">
                    <input type="text" id="search" class="form-control text-center" placeholder="Rechercher la zone de livraison"> 
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2"></th>
                            <?php foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $produit) { ?>
                                <th class="text-center"><?= $produit->name() ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i =0; foreach (Home\ZONELIVRAISON::findBy([], [], ["name"=>"ASC"]) as $key => $zone) {
                            $i++; ?>
                            <tr class="clients">
                                <td><i class="fa fa-truck"></i></td>
                                <td class="gras"><?= $zone->name(); ?></td>
                                <?php $i =0; foreach (Home\PRODUIT::findBy([], [], ["name"=>"ASC"]) as $key => $prod) { 
                                    $pz = new Home\PRIX_ZONELIVRAISON();
                                    $datas = $prod->fourni("prix_zonelivraison", ["zonelivraison_id ="=>$zone->getId()]);
                                    if (count($datas) > 0) {
                                        $pz = $datas[0];
                                    }
                                    ?>
                                    <td class="text-center" ><?= money($pz->price); ?> <?= $params->devise ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
</div>
