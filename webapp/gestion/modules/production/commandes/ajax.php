<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($action == "approuver") {
	$datas = SINISTRE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$sinistre = $datas[0];
		$data = $sinistre->approuver();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "entretien2") {
	if (getSession("sinistre") != null) {
		$entretien = new ENTRETIENVEHICULE;
		$sinistre = getSession("sinistre");
		$entretien->cloner($sinistre);
		$entretien->hydrater($_POST);
		$entretien->name = "Entretein suite au sinitre #".$sinistre->ticket." // ".$sinistre->typesinistre->name;
		$entretien->typeentretienvehicule_id = 1;
		$entretien->setId(null);
		$data = $entretien->enregistre();
		if ($data->status) {
			unset_session("sinistre");
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}




if ($action == "refuser") {
	$datas = SINISTRE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$sinistre = $datas[0];
		$data = $sinistre->refuser();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}
