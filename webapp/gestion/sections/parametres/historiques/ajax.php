<?php 
namespace Home;
require '../../../../../core/root/includes.php';
use Native\ROOTER;
use Native\RESPONSE;
use Native\FICHIER;


$data = new RESPONSE;
extract($_POST);


if ($action == "historiques") { 
	$date2 = date("Y-m-d", strtotime(dateAjoute1($date2, 1)));
	$historiques = HISTORY::findBy(["created >="=>$date1, "created <="=>$date2], [], ["created"=>"DESC"]);
	?>
	<div class="card latest-activity-card"><br>
		<h2 class="subtitle text-center mp5">Tous les historiques du <?= datecourt($date1) ?> au <?= datecourt(dateAjoute1($date2, -1)) ?></h2>
		<div class="card-block">
			<div class="latest-update-box">
				<?php 
				$date = "";
				foreach ($historiques as $key => $historique) {  
					if ($date != date("Y-m-d", strtotime($historique->created))) {
						$date = date("Y-m-d", strtotime($historique->created)); ?>
						<div class="card-header">
							<h5><?= datecourt($date) ?></h5>
						</div>
					<?php } ?>
					<div class="row mp5">
						<div class="col-auto text-right update-meta">
							<i class="fa fa-history bg-simple-c-blue update-icon"></i>
							<p class="text-muted m-b-0 d-inline"><?= heurecourt($historique->created) ?></p>
						</div>
						<div class="col">
							<h6 class="mp0"><?= $historique->auteur() ?></h6>
							<p class="text-muted m-b-15"><?= $historique->sentense ?></p>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="text-right">
			............
		</div>
	</div>
	<?php 
}

