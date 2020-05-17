<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

  <div id="wrapper">

    <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

    <div id="page-wrapper" class="gray-bg">

      <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-9">
          <h2 class="text-uppercase text-green gras">Programmation des livraisons</h2>
          <div class="container">

          </div>
        </div>
        <div class="col-sm-3">
          <div class="row">
            <div class="col-md-12">
              
            </div>
          </div>
        </div>
      </div>

      <div class="wrapper wrapper-content">
        <div class="ibox">
          <div class="ibox-title">
            <h5>Programme de livraison</h5>
            <div class="ibox-tools">
             
            </div>
          </div>
          <div class="ibox-content">
            <table class="table table-hover table-commande">
              <tbody>
                <?php for ($i=0; $i < 7; $i++) {
                  $date = dateAjoute($i);
                  $datas = Home\LIVRAISON::findBy(["etat_id ="=>Home\ETAT::PARTIEL, "DATE(datelivraison) ="=>$date])
                  ?>
                  <tr>
                    <td><h2 class="gras"><?= datecourt($date) ?></h2></td>
                    <td style="width: 80%;" class="border-left">
                      <div class="row">
                        <?php foreach ($datas as $key => $livraison) {
                          $livraison->actualise();
                          $lots = $livraison->fourni("lignelivraison");
                          ?>
                          <div class="col-md-6 border-right border-bottom" style="margin-bottom: 2%;">
                            <h4><?= $livraison->groupecommande->client->name() ?> 
                            || <small onclick="modifier(<?= $livraison->getId() ?>)" class=" cursor"><i class="fa fa-pencil"></i> Modifier</small> 
                            <small onclick="deleteWithPassword('livraison', <?= $livraison->getId() ?>)" class="pull-right cursor"><i class="fa fa-close text-red fa-2x"></i></small>&nbsp;&nbsp;&nbsp;
                          </h4>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <?php foreach ($lots as $key => $ligne) { 
                                  $ligne->actualise();  ?>
                                  <th class="text-center"><?= $ligne->produit->name() ?></th>
                                <?php } ?>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <?php foreach ($lots as $key => $ligne) { 
                                  $ligne->actualise();  ?>
                                  <th class="text-center"><?= $ligne->quantite ?></th>
                                <?php } ?>
                              </tr>
                            </tbody>
                          </table>
                          <?php if ($date == dateAjoute()) { ?>
                           <button style="margin-top: -3%" onclick="validerProg(<?= $livraison->getId() ?>)" class="cursor simple_tag pull-right"><i class="fa fa-file-text-o"></i> Faire la livraison</button>
                         <?php } ?>
                       </div>
                     <?php } ?>
                   </div>
                 </td>
               </tr>
             <?php  } ?>
           </tbody>
         </table>

       </div>
     </div>
   </div>


   <?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?> 

 </div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
