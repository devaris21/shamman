<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "newressource") {
	$params = PARAMS::findLastId();
	$rooter = new ROOTER;
	$ressources = [];
	if (getSession("ressources") != null) {
		$ressources = getSession("ressources"); 
	}
	if (!in_array($id, $ressources)) {
		$ressources[] = $id;
		$datas = RESSOURCE::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$ressource = $datas[0];
			?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeRessource(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td >
					<img style="width: 40px" src="<?= $rooter->stockage("images", "ressources", $ressource->image) ?>">
				</td>
				<td class="text-left">
					<h4 class="mp0 text-uppercase"><?= $ressource->name() ?></h4>
					<small><?= $ressource->unite ?></small>
				</td>
				<td><h4>X</h4></td>
				<td width="70"><input type="text" number class="form-control text-center gras" value="1" style="padding: 3px"></td>
				<td><?= $ressource->unite ?></td>
			</tr>
			<?php
		}
	}
	session("ressources", $ressources);
}


if ($action == "supprimeRessource") {
	$ressources = [];
	if (getSession("ressources") != null) {
		$ressources = getSession("ressources"); 
		foreach ($ressources as $key => $value) {
			if ($value == $id) {
				unset($ressources[$key]);
			}
			session("ressources", $ressources);
		}
	}
}



if ($action == "enregistrerApprovisionnement") {
	$params = PARAMS::findLastId();
	$ressources = explode(",", $tableau);
	if (count($ressources) > 0) {
		if (!in_array($modepayement_id, [MODEPAYEMENT::PRELEVEMENT_ACOMPTE])){

			$approvisionnement = new APPROVISIONNEMENT();
			$approvisionnement->hydrater($_POST);
			$data = $approvisionnement->enregistre();
			if ($data->status) {
				foreach ($ressources as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$qte = end($lot);
					$datas = RESSOURCE::findBy(["id ="=> $id]);
					if (count($datas) == 1) {
						$ressource = $datas[0];

						$ligne = new LIGNEAPPROVISIONNEMENT;
						$ligne->approvisionnement_id = $approvisionnement->getId();
						$ligne->ressource_id = $id;
						$ligne->quantite = $qte;
						$ligne->save();	
					}
				}

				$payement = new OPERATION();
				$payement->categorieoperation_id = CATEGORIEOPERATION::APPROVISIONNEMENT;
				$payement->modepayement_id = $modepayement_id;
				$payement->montant = $montant;
				$payement->client_id = CLIENT::CLIENTSYSTEME;
				$payement->comment = "Réglement de la facture pour l'approvisionnement de ressources N°".$approvisionnement->reference;
				$data = $payement->enregistre();

				$approvisionnement->operation_id = $data->lastid;
				$data = $approvisionnement->save();
			}
		}else{
			$data->status = false;
			$data->message = "Ce mode de payement ne peut être selectionner pour cette opération !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
	}

	echo json_encode($data);
}





if ($action == "annuler") {
	$datas = MISSION::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		$mission = $datas[0];
		$data = $mission->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite pendant le processus, veuillez recommencer !";
	}	
	echo json_encode($data);
}