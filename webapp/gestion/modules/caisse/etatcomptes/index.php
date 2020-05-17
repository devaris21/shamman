<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-6">
                <h2>Etat récapitulatif de la caisse</h2>
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
                                <div class="col-sm-4">
                                    <img style="width: 25%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                </div>
                                <div class="col-sm-8 text-right">
                                    <h2 class="title text-uppercase gras">Etat récapitulatif de la caisse</h2>
                                    <h3>Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h3>
                                </div>
                            </div><br><br>

                            <div class="row" style="margin-top: -2%;">
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <h3> Entrées </h3>
                                        <h3 class="font-bold"><?= money(Home\OPERATION::entree($date1, $date2)) ?> <?= $params->devise ?></h3>
                                    </div>
                                </div>
                                <div class="col-md ">
                                    <div class="widget style2 red-bg">
                                        <h3>Dépenses </h3>
                                        <h3 class="font-bold"><?= money(Home\OPERATION::sortie($date1, $date2)) ?> <?= $params->devise ?></h3>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="widget style2 bg-blue">
                                        <h3> Résultats </h3>
                                        <h3 class="font-bold"><?= money(Home\OPERATION::resultat($date1, $date2)) ?> <?= $params->devise ?></h3>
                                    </div>
                                </div>
                            </div><hr>


                            <h4>Tableau des compte</h4>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center text-uppercase gras" style="font-size: 11px">
                                        <th style="visibility: hidden;"></th>
                                        <th>Entrée</th>
                                        <th>Sortie</th>
                                        <th>Résultats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-right: 2px dashed grey">Solde du compte au <?= datecourt($date1) ?></td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center"><h4 class="text-center"><?= $last = $repport = money(Home\OPERATION::resultat(Home\PARAMS::DATE_DEFAULT , $date1)) ?> <?= $params->devise ?></td>
                                        </tr>
                                        <?php foreach ($datas as $key => $item) {
                                        $item->actualise(); ?>
                                            <tr>
                                                <td class="gras" style="border-right: 2px dashed grey"><?= $item->name() ?></td>
                                                <?php if ($item->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE) { ?>
                                                    <td class="text-center gras text-green"><?= money($item->montant) ?> <?= $params->devise ?></td>
                                                    <td class="text-center"> - </td>
                                                <?php }else{ ?>
                                                    <td class="text-center"> - </td>
                                                    <td class="text-center gras text-red"><?= money($item->montant) ?> <?= $params->devise ?></td>
                                                <?php } ?>                                            
                                                  <?php $last += ($item->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)? $item->montant : -$item->montant ; ?>
                                            <td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr style="height: 12px;"></tr>
                                        <tr>
                                            <td ><h4 class="text-uppercase mp0 text-right">Solde du compte au <?= datecourt($date2) ?></h4></td>
                                            <td><h3 class="text-center gras text-uppercase text-green"><?= money($entree) ?> <?= $params->devise ?></h3></td>
                                            <td><h3 class="text-center gras text-uppercase text-red"><?= money($sortie) ?> <?= $params->devise ?></h3></td>
                                            <td><h3 class="text-center gras text-uppercase"><?= money($resultat) ?> <?= $params->devise ?></h3></td>
                                        </tr>
                                    </tbody>
                                </table><hr>

                                <div class="">
                                    <h4>Courbe d'évoluton du compte</h4>
                                    <div class="flot-chart">
                                        <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                    </div>
                                </div><hr>

                                <div class="row">
                                    <div class="col-6">
                                        <h4>Courbe de répartition des entrées</h4>
                                        <div>
                                            <canvas id="chart" height="270"></canvas>
                                        </div><br>
                                    </div>

                                    <div class="col-6">
                                        <h4>Courbe de répartition des dépenses</h4>
                                        <div>
                                            <canvas id="chart2" height="270"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4>Observations</h4>
                                    <ul style="font-style: italic;">
                                        <?php if (count($datas1) > 0) { ?>
                                           <li> <b>"<?= $datas1[0]->name() ?>"</b> réprésente à lui seul <b><?= $datas1[0]->pct ?>%</b> de vos entrée en caisse</li>
                                        <?php }  ?>

                                        <?php if (count($datas1) > 2) { ?>
                                            <li><b><?= $datas1[0]->pct + $datas1[1]->pct ?>%</b> de vos entrées en caisse concernent <b>"<?= $datas1[0]->name() ?>"</b> et <b>"<?= $datas1[1]->name() ?>"</b></li>
                                        <?php }  ?>
                                    </ul><hr>

                                   
                                     <ul style="font-style: italic;">
                                        <?php if (count($datas2) > 0) { ?>
                                           <li> <b>"<?= $datas2[0]->name() ?>"</b> réprésente à lui seul <b><?= $datas2[0]->pct ?>%</b> de vos dépenses</li>
                                        <?php }  ?>

                                        <?php if (count($datas2) > 2) { ?>
                                            <li><b><?= $datas2[0]->pct + $datas2[1]->pct ?>%</b> de vos dépenses concernent <b>"<?= $datas2[0]->name() ?>"</b> et <b>"<?= $datas2[1]->name() ?>"</b></li>
                                        <?php }  ?>
                                    </ul>
                                </div>



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

        var data1 = [<?php foreach ($stats as $key => $data) { ?>[gd(<?= $data->year ?>, <?= $data->month ?>, <?= $data->day ?>), <?= $data->entree ?>], <?php } ?> ];

        var data2 = [<?php foreach ($stats as $key => $data) { ?>[gd(<?= $data->year ?>, <?= $data->month ?>, <?= $data->day ?>), <?= $data->sortie ?>], <?php } ?> ];

        var data3 = [<?php foreach ($stats as $key => $data) { ?>[gd(<?= $data->year ?>, <?= $data->month ?>, <?= $data->day ?>), <?= $data->resultat ?>], <?php } ?> ];


        var dataset = [
        {
            label: "Entrée",
            data: data1,
            color: "#1ab394",
            bars: {
                show: true,
                align: "right",
                barWidth: 12 * 60 * 60 * 600,
                lineWidth:0
            }

        }, 
        {
            label: "Dépenses",
            data: data2,
            color: "#ff0000",
            bars: {
                show: true,
                align: "left",
                barWidth: 12 * 60 * 60 * 600,
                lineWidth:0
            }

        },
        {
            label: "La Caisse",
            data: data3,
            yaxis: 2,
            color: "#1C84C6",
            lines: {
                lineWidth:1,
                show: true,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.4
                    }]
                }
            },
            splines: {
                show: false,
                tension: 0.6,
                lineWidth: 1,
                fill: 0.1
            },
        }
        ];

        var options = {
            xaxis: {
                mode: "time",
                tickSize: [<?= $data->nb  ?>, "day"],
                tickLength: 0,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 10,
                color: "#d5d5d5"
            },
            yaxes: [{
                position: "left",
                color: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 3
            }, {
                position: "right",
                clolor: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: ' Arial',
                axisLabelPadding: 67
            }
            ],
            legend: {
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: true,
                borderWidth: 0
            }
        };

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }
        var previousPoint = null, previousLabel = null;
        $.plot($("#flot-dashboard-chart"), dataset, options);


        var doughnutOptions = {
            responsive: false,
            legend: false
        };

        var doughnutData = {
            labels: [<?php foreach ($datas1 as $key => $item){ ?> "<?= $item->name() ?>", <?php } ?>],
            datasets: [{
                data: [<?php foreach ($datas1 as $key => $item){ ?> <?= $item->montant ?>, <?php } ?>],
                backgroundColor: ["#a3e1d4","#17a2b8","#b5b8cf", "#28a745", "#6610f2", "#007bff"]
            }]
        } ;
        var ctx4 = document.getElementById("chart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


        var doughnutData2 = {
              labels: [<?php foreach ($datas2 as $key => $item){ ?> "<?= $item->name() ?>", <?php } ?>],
            datasets: [{
                data: [<?php foreach ($datas2 as $key => $item){ ?> <?= $item->montant ?>, <?php } ?>],
                backgroundColor: ["#dc3545","#ffc107","#fd7e14", "#dd899s","#ffa107","#fd1274"]
            }]
        } ;
        var ctx5 = document.getElementById("chart2").getContext("2d");
        new Chart(ctx5, {type: 'doughnut', data: doughnutData2, options:doughnutOptions});

    })
</script>
</body>

</html>
