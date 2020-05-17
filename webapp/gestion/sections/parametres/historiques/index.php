<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2 class="text-uppercase">historiques des actions</h2>
            </div>
            <div class="col-sm-8">
                
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <label>Début de la période</label>
                                    <input type="date" name="date1" class="form-control" value="<?= dateAjoute(-2) ?>">
                                </div><br>
                                <div>
                                    <label>Fin de la période</label>
                                    <input type="date" name="date2" class="form-control" value="<?= dateAjoute() ?>">
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="col-md-9 affichage">
                        <h1 style="margin-top: 10%;" class="text-center text-muted">
                            <span class="loading rhomb"></span> <br>
                        Veuillez patienter</h1>
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
