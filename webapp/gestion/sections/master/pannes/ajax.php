<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
$data = new RESPONSE;
extract($_POST);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($action == "validerDemandeEntretien") {
	$datas = DEMANDEENTRETIEN::findBy(["id ="=>getSession("demandeentretien_id")]);
	if (count($datas) == 1) {
		$demande = $datas[0];

		$payement = new OPERATION();
		$payement->hydrater($_POST);
		$payement->categorieoperation_id = CATEGORIEOPERATION::ENTRETIENVEHICULE;
		$payement->montant = $price;
		$payement->comment = "Avance sur réglement de la facture pour l'entretien du véhicule suite à la demande N°".$demande->reference;
		$data = $payement->enregistre();
		if ($data->status) {
			$data = $demande->approuver();
			if ($data->status) {
				$entretien = new ENTRETIENVEHICULE;
				$entretien->cloner($demande);
				$entretien->hydrater($_POST);
				$entretien->name = $demande->typeentretienvehicule->name." suite à la déclaration de panne ";
				$entretien->setId(null);
				$files = [];
				if (isset($_FILES)) {
					foreach ($_FILES as $key => $value) {
						if ($key !== "id" && $value != "") {
							$files[] = $value;
						}
					}
				}
				$entretien->files = $files;
				$data = $entretien->enregistre();
			}	
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "terminerSansEntretenirVehicule") {
	$datas = DEMANDEENTRETIEN::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$demande = $datas[0];
		$data = $demande->approuver();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "annulerDemandeEntretien") {
	$datas = DEMANDEENTRETIEN::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$demande = $datas[0];
		$data = $demande->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "validerEntretienVehicule") {
	$datas = ENTRETIENVEHICULE::findBy(["id ="=>getSession("entretienvehicule_id")]);
	if (count($datas) == 1) {
		$entretien = $datas[0];
		if ($montant > 0) {
			$payement = new OPERATION();
			$payement->hydrater($_POST);
			$payement->categorieoperation_id = CATEGORIEOPERATION::ENTRETIENVEHICULE;
			$payement->comment = "Réglement de la facture pour l'entretien du véhicule N°".$entretien->reference;
			$data = $payement->enregistre();
			if ($data->status) {
				$entretien->price += $montant;
				$data = $entretien->approuver();
			}	
		}	

		if (intval($montant) == 0) {
			$data = $entretien->approuver();
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}


if ($action == "annulerEntretienVehicule") {
	$datas = ENTRETIENVEHICULE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$entretien = $datas[0];
		$data = $entretien->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "formEntretienMachine") {
	$datas = PANNE::findBy(["id ="=>getSession("panne_id")]);
	if (count($datas) == 1) {
		$panne = $datas[0];

		$payement = new OPERATION();
		$payement->hydrater($_POST);
		$payement->categorieoperation_id = CATEGORIEOPERATION::ENTRETIENVEHICULE;
		$payement->montant = $price;
		$payement->comment = "Avance sur réglement de la facture pour l'entretien du véhicule suite à la panne N°".$panne->reference;
		$data = $payement->enregistre();
		if ($data->status) {
			$data = $panne->approuver();
			if ($data->status) {
				$entretien = new ENTRETIENMACHINE;
				$entretien->cloner($panne);
				$entretien->hydrater($_POST);
				$entretien->name = $panne->title." suite à la déclaration de panne ";
				$entretien->setId(null);
				$files = [];
				if (isset($_FILES)) {
					foreach ($_FILES as $key => $value) {
						if ($key !== "id" && $value != "") {
							$files[] = $value;
						}
					}
				}
				$entretien->files = $files;
				$data = $entretien->enregistre();
			}	
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "terminerSansEntretenirMachine") {
	$datas = PANNE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$demande = $datas[0];
		$data = $demande->approuver();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "annulerPanne") {
	$datas = PANNE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$panne = $datas[0];
		$data = $panne->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "validerEntretienMachine") {
	$datas = ENTRETIENMACHINE::findBy(["id ="=>getSession("entretienmachine_id")]);
	if (count($datas) == 1) {
		$entretien = $datas[0];
		if ($montant > 0) {
			$payement = new OPERATION();
			$payement->hydrater($_POST);
			$payement->categorieoperation_id = CATEGORIEOPERATION::ENTRETIENVEHICULE;
			$payement->comment = "Réglement de la facture pour l'entretien du véhicule N°".$entretien->reference;
			$data = $payement->enregistre();
			if ($data->status) {
				$entretien->price += $montant;
				$data = $entretien->approuver();
			}	
		}	

		if (intval($montant) == 0) {
			$data = $entretien->approuver();
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}


if ($action == "annulerEntretienMachine") {
	$datas = ENTRETIENMACHINE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$entretien = $datas[0];
		$data = $entretien->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////