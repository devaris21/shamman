<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Article</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>Miscellaneous</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Article</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

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
                                    <h2 class="title text-uppercase gras">Etat récapitulatif de la production<br>du personel</h2>
                                    <h3>Du vendredi 22 mars 2020 au vendredi 22 mars 2020</h3>
                                </div>
                            </div><br><br>

                            <div class="row" style="margin-top: -2%;">
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <span> Livraisons </span>
                                        <h2 class="font-bold">26'C</h2>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <span> Autres entrées </span>
                                        <h2 class="font-bold">26'C</h2>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <span>Approvisionnement </span>
                                        <h2 class="font-bold">26'C</h2>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <span>Autres dépenses </span>
                                        <h2 class="font-bold">26'C</h2>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="widget style2 navy-bg">
                                        <span> Résultats </span>
                                        <h2 class="font-bold">26'C</h2>
                                    </div>
                                </div>
                            </div><br>


                            <h4>Tableau des compte</h4>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Ac 15</th>
                                        <th>Ac 15</th>
                                        <th>Ac 15</th>
                                        <th>Perte</th>
                                        <th>Résultats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>Groupe 1</h4>
                                            <span>- Lorem ipsum.</span><br>
                                            <span>- Lorem ipsum.</span><br>
                                            <span>- Lorem ipsum.</span>
                                        </td>
                                        <td>-</td>
                                        <td>450</td>
                                        <td>560 000</td>
                                        <td>450</td>
                                    </tr>
                                    <tr>
                                        <td>Achats de matériaux de fabrication</td>
                                        <td> - </td>
                                        <td>125 000</td>
                                        <td>125 000</td>
                                    </tr>
                                    <tr>
                                        <td>Achats de matériaux de fabrication</td>
                                        <td>125 000</td>
                                        <td> - </td>
                                        <td>125 000</td>
                                    </tr>
                                    <tr>
                                        <td>Achats de matériaux de fabrication</td>
                                        <td>125 000</td>
                                        <td> - </td>
                                        <td>125 000</td>
                                    </tr>
                                    <tr>
                                        <td>Achats de matériaux de fabrication</td>
                                        <td> - </td>
                                        <td>125 000</td>
                                        <td>125 000</td>
                                    </tr>
                                    <tr>
                                        <td><h4 class="text-uppercase mp0 text-right">Solde du compte au 22/05/2020</h4></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>560 000</td>
                                    </tr>
                                </tbody>
                            </table><hr>

                            <div class="row">
                                <div class="col-8">
                                    <h4>Courbe d'évoluton du compte</h4>
                                    <div>
                                        <canvas id="radarChart" height="230"></canvas>
                                    </div><br>

                                    <h4>Observations</h4>
                                    <ul style="font-style: italic;">
                                        <li>"Entretiens de machine" réprésente à lui seul 60% de vos dépenses</li>
                                        <li>88% de vos dépenses concernent les factures d'eau et facture d'élec</li>
                                    </ul>

                                    <ul style="font-style: italic;">
                                        <li>"Entretiens de machine" réprésente à lui seul 60% de vos dépenses</li>
                                        <li>88% de vos dépenses concernent les factures d'eau et facture d'élec</li>
                                    </ul>
                                </div>

                                <div class="col-4">
                                    <h4>Courbe de répartition des entrées</h4>
                                    <div>
                                        <canvas id="doughnutChart" height="270"></canvas>
                                    </div>
                                </div>
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


</body>

</html>
