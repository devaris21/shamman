<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox" >
                        <div class="ibox-content border"  style="background-color: #fcfcfc">
                            <div class="">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="col-3">
                                                <img style="width: 120%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                            </div>
                                            <div class="col-9">
                                                <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                                <h5 class="mp0"><?= $params->postale ?></h5>
                                                <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                                <h5 class="mp0">Email: <?= $params->email ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <h2 class="title text-uppercase gras text-blue">Bon de caisse</h2>
                                        <h3 class="text-uppercase">N°<?= $operation->reference ?></h3>
                                        <h5><?= datelong($operation->created) ?></h5>  
                                        <h4><small>Bon délivré par :</small> <span class="text-uppercase"><?= $operation->employe->name() ?></span></h4>                                
                                    </div>
                                </div><hr class="mp3">

                                <br>
                                <div style="margin: auto 5%;">
                                    <div class="row" style="margin-top: 1%;">
                                        <div class="col-6">
                                            <br>
                                            <span class="text-uppercase gras">Opération par <?= $operation->modepayement->name() ?></span>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span>Montant :</span> <span class="prix text-uppercase"><?= money($operation->montant) ?> <?= $params->devise ?></span>
                                        </div>
                                    </div><br><br>

                                    <div class="text">
                                        <span><?= $operation->categorieoperation->typeoperationcaisse->name() ?> d'un montant de</span> <span class="lettre text-capitalize"><?= enLettre($operation->montant) ?> <?= $params->devise  ?></span><br>
                                        <span>pour <i><?= $operation->comment ?></i>.</span>
                                        <p class="m-b-xs"><?= $operation->structure ?> - <?= $operation->numero ?></p><br>
                                    </div>

                                    <div class="text">
                                        <h4><u><?= ($operation->categorieoperation->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::SORTIE)?"Bénéficiaire":"Client"  ?> :</u> <span class="text-uppercase"><?= $operation->client->name() ?></span></h4>
                                    </div>

                                    <?php if($operation->client_id > 1){ ?>
                                        <table class="table">
                                            <tbody>
                                                <tr class="border">
                                                    <td colspan="3" class="text-right">
                                                        <h4 class="text-uppercase mp0">Solde de l'acompte du client =</h4>
                                                    </td>
                                                    <td></td>
                                                    <td colspan="1" class="text-center"><h3 class="gras text-"><?= money($operation->acompteClient) ?> <?= $params->devise ?></h3></td>
                                                </tr>
                                                <tr class="border">
                                                    <td colspan="3" class="text-uppercase text-right"><h4 class=" text-red ">Dette totale du client = </h4></td>
                                                    <td></td>
                                                    <td colspan="1" class="text-center"><h3 class="gras text-danger"><?= money($operation->detteClient) ?> <?= $params->devise ?></h3></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <?php } ?>

                                    <br><br>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-left" style="height: 90px">
                                                <span><u>Signature du bénéficiaire</u></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right" style="height: 90px">
                                                <span><u>Signature & Cachet</u></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <hr><hr>
                            <p class="text-center"><small><i>* Aucun remboursement n'est admis après réglement !</i></small></p>

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
