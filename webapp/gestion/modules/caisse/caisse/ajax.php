<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	$rooter = new ROOTER();
	$params = PARAMS::findLastId();

	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	$employe = $datas[0];

	?>
	<tr>
		<td colspan="2">Repport du solde </td>
		<td class="text-center">-</td>
		<td class="text-center">-</td>
		<td style="background-color: #fafafa" class="text-center"><?= money($repport = $last = OPERATION::resultat(PARAMS::DATE_DEFAULT , dateAjoute($jour-1))) ?> <?= $params->devise ?></td>
	</tr>
	<?php
	$entrees = $depenses = [];
	$operations = OPERATION::findBy(["DATE(created) >= "=> dateAjoute(intval($jour))]);
	foreach ($operations as $key => $operation) {
		$operation->actualise(); 
		if ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
			$entrees[] = $operation;
		}else{
			$depenses[] = $operation;
		} ?>
		<tr>
			<td style="background-color: rgba(<?= hex2rgb($operation->categorieoperation->color) ?>, 0.6);" width="15"><a target="_blank" href="<?= $rooter->url("gestion", "fiches", "boncaisse", $operation->getId())  ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
			<td>
				<h6 style="margin-bottom: 3px" class="mp0 text-uppercase gras <?= ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE)?"text-green":"text-red" ?>"><?= $operation->categorieoperation->name() ?>  

				<?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
					|
					&nbsp;&nbsp;<i onclick="modifierOperation(<?= $operation->getId() ?>)" class="cursor fa fa-pencil text-dark"></i> 
					&nbsp;&nbsp;<i class="cursor fa fa-close text-red" onclick="suppressionWithPassword('operation', <?= $operation->getId() ?>)"></i>
				<?php } ?>

				<span class="pull-right"><i class="fa fa-clock-o"></i> <?= datelong($operation->created) ?></span>
			</h6>
			<i><?= $operation->comment ?> ## <u style="font-size: 9px; font-style: italic;"><?= $operation->structure ?> - <?= $operation->numero ?></u></i>
		</td>
		<?php if ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) { ?>
			<td class="text-center text-green gras" style="padding-top: 12px;">
				<?= money($operation->montant) ?> <?= $params->devise ?>
			</td>
			<td class="text-center"> - </td>
		<?php }elseif ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE) { ?>
			<td class="text-center"> - </td>
			<td class="text-center text-red gras" style="padding-top: 12px;">
				<?= money($operation->montant) ?> <?= $params->devise ?>
			</td>
		<?php } ?>
		<?php $last += ($operation->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE)? $operation->montant : -$operation->montant ; ?>
		<td class="text-center gras" style="padding-top: 12px; background-color: #fafafa"><?= money($last) ?> <?= $params->devise ?></td>
	</tr>
<?php } ?>
<tr style="height: 15px"></tr>
<tr>
	<td style="border-right: 2px dashed grey" colspan="2"><h4 class="text-uppercase mp0 text-right">Total des comptes au <?= datecourt(dateAjoute()) ?></h4></td>
	<td><h3 class="text-center text-green"><?= money(comptage($entrees, "montant", "somme") + $repport) ?> <?= $params->devise ?></h3></td>
	<td><h3 class="text-center text-red"><?= money(comptage($depenses, "montant", "somme")) ?> <?= $params->devise ?></h3></td>
	<td style="background-color: #fafafa"><h3 class="text-center text-blue gras"><?= money($last) ?> <?= $params->devise ?></h3></td>
</tr>
<?php 
}



if ($action == "valider") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = OPERATION::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$operation = $datas[0];
				$data = $operation->valider();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
			}
		}else{
			$data->status = false;
			$data->message = "Votre mot de passe ne correspond pas !";
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas effectué cette opération !";
	}
	echo json_encode($data);
}



?>