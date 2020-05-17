<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "prix") {
	$items = explode(",", $tableau);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0];
		$val = end($data);
		$datas = PRIX_ZONELIVRAISON::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price = intval($val);
			$data = $pz->save();
		}
	}
	echo json_encode($data);
}



if ($action == "exigence") {
	$items = explode(",", $tableau);
	foreach ($items as $key => $value) {
		$lot = explode("-", $value);
		$id = $lot[0]; 
		$prod = $lot[1];
		$res= $lot[2];

		$datas = EXIGENCEPRODUCTION::findBy(["id ="=>$id]);
		if (count($datas) == 1) {
			$ligne = $datas[0];
			$ligne->quantite_produit = $prod;
			$ligne->quantite_ressource = $res;
			$data = $ligne->enregistre();
		}
	}
	echo json_encode($data);
}



if ($action == "formPayeProduit") {
	$items = explode(",", $tableau);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price = intval($val);
			$data = $pz->save();
		}
	}	

	$items = explode(",", $tableau1);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price_rangement = intval($val);
			$data = $pz->save();
		}
	}

	$items = explode(",", $tableau2);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price_livraison = intval($val);
			$data = $pz->save();
		}
	}
	echo json_encode($data);
}



if ($action == "formPayeProduitFerie") {
	$items = explode(",", $tableau);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYEFERIE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price = intval($val);
			$data = $pz->save();
		}
	}	

	$items = explode(",", $tableau1);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYEFERIE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price_rangement = intval($val);
			$data = $pz->save();
		}
	}

	$items = explode(",", $tableau2);
	foreach ($items as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0]; $val = end($data);

		$datas = PAYEFERIE_PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$pz = $datas[0];
			$pz->price_livraison = intval($val);
			$data = $pz->save();
		}
	}
	echo json_encode($data);
}




if ($action == "autoriser") {
	$datas = ROLE_EMPLOYE::findBy(["employe_id ="=> $employe_id, "role_id ="=> $role_id]);
	if (count($datas) == 0) {
		$rem = new ROLE_EMPLOYE();
		$rem->hydrater($_POST);
		$data = $rem->enregistre();
	}else{
		$data->status = false;
		$data->message = "L'employé dispose déjà de ce droit !";
	}
	echo json_encode($data);
}


if ($action == "refuser") {
	$datas = ROLE_EMPLOYE::findBy(["employe_id ="=> $employe_id, "role_id ="=> $role_id]);
	if (count($datas) == 1) {
		$rem = $datas[0];
		if (!$rem->isProtected()) {
			$rem = $datas[0];
			$data = $rem->delete();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas supprimer cet accès, il est protégé !";
		}
	}else{
		$data->status = false;
		$data->message = "L'accès est déjà refusé à cet employé !";
	}
	echo json_encode($data);
}