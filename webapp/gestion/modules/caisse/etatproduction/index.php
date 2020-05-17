<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-16">
                <h2>Etat récapitulatif de la production et des ressources</h2>
                <form id="formFiltrer" class="row" method="POST">
                    <div class="col-4">
                        <input type="date" value="<?= $date1  ?>" name="date1" class="form-control">
                    </div>
                    <div class="col-4">
                        <input type="date" value="<?= $date2 ?>" name="date2" class="form-control">
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-sm btn-primary dim" onclick="filtrer()"><i class="fa fa-search"></i> Filtrer</button>
                    </div>
                </form>  
            </div>
            <div class="col-lg-6">

            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox"  >
                        <div class="ibox-content" style="background-image: url(<?= $this->stockage("images", "societe", "filigrane.png")  ?>) ; background-size: 50%; background-position: center center; background-repeat: no-repeat;">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img style="width: 25%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                </div>
                                <div class="col-sm-9 text-right">
                                    <h2 class="title text-uppercase gras">Etat récapitulatif de la production<br>et des ressources</h2>
                                    <h3>Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h3>
                                </div>
                            </div><hr><br>

                            <h4>Tableau du stock sur la période</h4>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="text-uppercase text-center" style="font-size: 11px;">
                                        <th></th>
                                        <th>Stock Avant <?= datecourt2(dateAjoute1($date1, -1)) ?></th>
                                        <th>Production</th>
                                        <th colspan="2" width="10">Perte</th>
                                        <th>Livraison</th>
                                        <th>Stock en fin <?= datecourt2($date2) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produits as $key => $produit) { ?>
                                        <tr>
                                            <td><span class="gras text-uppercase"><?= $produit->name() ?></span> <br> <small><?= $produit->description ?></small></td>
                                            <td class="text-center"><br><h3 class="gras text-muted"><?= money($produit->stock(dateAjoute1($date1, -1))) ?></h3></td>
                                            <td class="text-center"><br><h3 class="text-green gras"><?= money($produit->production) ?></h3></td>
                                            <td class="text-center"><br><h4 class="text-red"><?= money($produit->perte) ?></h4></td>
                                            <td class="text-center" ><?= ($produit->production + $produit->perte > 0)?round( ($produit->perte / ($produit->production + $produit->perte) * 100 ), 2):0 ?> %<br><small>de la production</small></td>
                                            <td class="text-center"><br><h4><?= money($produit->livraison) ?></h4></td>
                                            <td class="text-center" ><h2 class="gras"><?= money($produit->stock(dateAjoute1($date2, 1))) ?></h2></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table><hr>


                            <div class="row">
                                <div class="col-6">
                                    <h4>Rapport de production, de livraison et de perte</h4>
                                    <div>
                                        <canvas id="radarChart" height="230"></canvas>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-right">Coût de production, rangement & livraison</h4><br>
                                    <table class="table ">
                                        <tbody>
                                            <tr>
                                                <td><h4 class="text-uppercase">Coût de Production</h4></td>
                                                <td><h4><?= money(comptage($productions, "total_production", "somme")) ?> <?= $params->devise ?></h4></td>
                                            </tr>
                                            <tr>
                                                <td><h4 class="text-uppercase">Coût de Rangement</h4></td>
                                                <td><h4><?= money(comptage($productions, "total_rangement", "somme")) ?> <?= $params->devise ?></h4></td>
                                            </tr>
                                            <tr>
                                                <td><h4 class="text-uppercase">Coût de Livraison</h4></td>
                                                <td><h4><?= money(comptage($productions, "total_livraison", "somme")) ?> <?= $params->devise ?></h4></td>
                                            </tr>
                                            <tr>
                                                <td><h4 class="text-uppercase">Coût Tricycle</h4></td>
                                                <td><h4><?= money(comptage($tricycles, "paye_tricycle", "somme")) ?> <?= $params->devise ?></h4></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><br>


                            <div>
                                <h4>Observations</h4>
                                <ul style="font-style: italic;">
                                    <li>Vous avez perdu beaucoup plus de <b><?= $produits[0]->name() ?></b></li>
                                    <li>Vous avez perdu en moyenne <b><?= ceil(comptage($produits, "perte", "somme") / dateDiffe($date1, $date2)) ?> produit</b> par <b>jour</b></li><br>

                                    <li> <?php if ($pertelivraison == 0) { ?>
                                        Toutes les pertes ont eu lieu lors du rangement
                                    <?php }elseif ($pertelivraison == 100) { ?>
                                        Toutes les pertes ont eu lieu lors de la livraison
                                    <?php }else{ ?>
                                        <b><?= $pertelivraison  ?>%</b> des pertes ont eu lieu lors da la livraison contre <b><?= 100 - $pertelivraison ?>%</b> lors du rangement
                                    <?php } ?>
                                </li>
                            </ul>
                        </div><hr><br>


                        <h4>Tableau comparatif de la consommation de ressource sur la période</h4>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center" >
                                    <th colspan="2">Production</th>
                                    <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                        <th>
                                            <span style="font-size: 11px;" class="text-uppercase"><?= $ressource->name()  ?></span>
                                            <br><small><?= $ressource->unite ?></small>
                                        </th>
                                    <?php }  ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produits as $key => $produit) { ?>
                                    <tr>
                                        <td><span class="gras text-uppercase"><?= $produit->name() ?></span> <br> <small><?= $produit->description ?></small></td>
                                        <td class="text-center"><h3 class="gras"><?= money($produit->production+$produit->perte) ?></h3></td>
                                        <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource) { 
                                            $name = trim($ressource->name()); ?>
                                            <td class="text-center"><?= round($produit->$name, 2); ?> <?= $ressource->abbr  ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php }  ?>

                                <tr style="height: 12px;"></tr>
                                <tr>
                                    <td colspan="2"><h5 class="gras text-uppercase mp0">Consommation totale dûe</h5>
                                        <small>(Ce qu'ils auraient normalement dû consommé)</small></td>
                                        <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource) { 
                                            $name = trim($ressource->name()); ?>
                                            <td class="text-center text-green gras"><?= round(comptage($produits, $name, "somme"), 2); ?> <?= $ressource->abbr  ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><h5 class="gras text-uppercase mp0">Consommation totale effective</h5>
                                            <small>(Consommation qu'ils ont effectivement déclaré)</small>
                                        </td>
                                        <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                            <td class="text-center gras"><?= money($ressource->consommee($date1, $date2)); ?> <?= $ressource->abbr  ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr style="height: 12px;"></tr>
                                    <tr>
                                        <td colspan="2"><h5 class="gras text-uppercase">Comparatif de la Consommation</h5></td>
                                        <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource) { 
                                            $name = trim($ressource->name()); 
                                            $a = comptage($produits, $name, "somme") - $ressource->consommee($date1, $date2); ?>
                                            <td class="text-center text-<?= ($a >= 0)?"green":"red" ?>"> Conso de <b><?= round(abs($a), 2) ?> <?= $ressource->abbr  ?></b> <br>en <?= ($a >= 0)?"moins":"plus" ?></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                            <small><i>* Selon la ressource, vous devez considerer une certaine marge de consommation sur la periode. (Ex: -/+ 5 sacs de ciments pour 30 jours)</i></small><br>
                            <small><i>* Si cette marge est franchie (positivement ou négativement), alors il y a un problème de production.<br> Soit ils n'utilisent pas les quantités néccéssaires pour une bonne qualité de la production, soit ils font du gaspillage de ressource.</i></small>
                            <hr>
                            <br><br>

                            <h4>Estimation des perte en ressource sur la période</h4>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center" >
                                        <th colspan="2"></th>
                                        <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                            <th>
                                                <span style="font-size: 11px;" class="text-uppercase"><?= $ressource->name()  ?></span>
                                                <br><small><?= $ressource->unite ?></small>
                                            </th>
                                        <?php }  ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2"><h5 class="gras text-uppercase mp0">Estimation en ressource</h5>
                                            <small>(Appréciez par vous-même)</small></td>
                                            <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource) { 
                                                $name = trim($ressource->name()); ?>
                                                <td class="text-center text-red gras"><?= round(comptage($produits, "perte-$name", "somme"), 2); ?> <?= $ressource->abbr  ?></td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table><hr>

                            </div>
                        </div>

                    </div>
                </div>


            </div>


            <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>


        </div>
    </div>


    <?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>
    <script type="text/javascript">
        $(function(){

         var radarOptions = {
            responsive: true
        };

        var radarData = {
            labels: [<?php foreach ($produits as $key => $data){ ?> "<?= $data->name() ?>", <?php } ?>],
            datasets: [
            {
                label: "Production",
                backgroundColor: "rgba(26,179,148,0.2)",
                borderColor: "rgba(26,179,148,1)",
                data: [<?php foreach ($produits as $key => $data){ ?> "<?= $data->production ?>", <?php } ?>]
            },
            {
                label: "Livraison",
                backgroundColor: "rgba(220,220,220,0.2)",
                borderColor: "rgba(220,220,220,1)",
                data: [<?php foreach ($produits as $key => $data){ ?> "<?= $data->livraison ?>", <?php } ?>]
            },
            {
                label: "Perte",
                backgroundColor: "rgba(220,10,10,0.2)",
                borderColor: "rgba(220,10,10,1)",
                data: [<?php foreach ($produits as $key => $data){ ?> "<?= $data->perte ?>", <?php } ?>]
            }
            ]
        };

        var ctx5 = document.getElementById("radarChart").getContext("2d");
        new Chart(ctx5, {type: 'radar', data: radarData, options:radarOptions});



        var radarData2 = {
            labels: [<?php foreach ($ressources as $key => $ressource){ ?> "<?= $ressource->name() ?>", <?php } ?>],
            datasets: [
            <?php  foreach (Home\RESSOURCE::getAll() as $key => $ressource){ 
                $name = trim($ressource->name());
                $a = mt_rand(0, 255); ?>
                {
                    label: "<?= $ressource->name()  ?>",
                    backgroundColor: "rgba(<?= $a ?>,<?= $a ?>,105,0.2)",
                    borderColor: "rgba(<?= $a ?>,<?= $a ?>,105,1)",
                    data: [<?php foreach ($produits as $key => $produit){ ?> <?= $produit->$name ?>, <?php } ?>]
                },
            <?php } ?>
            ]
        };
        var ctx6 = document.getElementById("radarChart2").getContext("2d");
        new Chart(ctx6, {type: 'radar', data: radarData2, options:radarOptions});
    })
</script>

</body>

</html>
