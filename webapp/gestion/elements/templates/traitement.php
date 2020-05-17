<?php 
namespace Home;
require '../../../../core/root/includes.php';
use Native\RESPONSE;
extract($_POST);

$data = new RESPONSE;




if ($action === "productionjour") {
	if ($manoeuvres != "" || (isset($groupemanoeuvre_id) && $groupemanoeuvre_id != "")) {
		$productionjour = PRODUCTIONJOUR::today();
		$test = true;
		foreach (RESSOURCE::getAll() as $key => $ressource) {
			$datas = $productionjour->fourni("ligneconsommationjour", ["ressource_id ="=>$ressource->getId()]);
			if (count($datas) == 1) {
				$ligne = $datas[0];
				if (intval($_POST["conso-".$ressource->getId()]) > ($ressource->stock(dateAjoute()) + $ligne->consommation) ) {
					$test = false;
					break;
				}
			}
		}

		if ($test) {
			$montant = 0;
			$productionjour->fourni("ligneproductionjour");
			foreach ($productionjour->ligneproductionjours as $cle => $ligne) {
				$ligne->production = intval($_POST["prod-".$ligne->produit_id]);
				$ligne->perte = intval($_POST["perte-".$ligne->produit_id]);
				$ligne->save();

				$ligne->actualise();
				$montant += $ligne->produit->coutProduction("production", $ligne->production);
			}

			$productionjour->fourni("ligneconsommationjour");
			foreach ($productionjour->ligneconsommationjours as $cle => $ligne) {
				$ligne->consommation = intval($_POST["conso-".$ligne->ressource_id]);
				$ligne->save();
			}


			$datas = $productionjour->fourni("manoeuvredujour");
			foreach ($datas as $cle => $ligne) {
				$ligne->delete();
			}

			if (isset($manoeuvres) && $manoeuvres != "") {
				$datas = explode(",", $manoeuvres);
				foreach ($datas as $key => $value) {
					$item = new MANOEUVREDUJOUR();
					$item->productionjour_id = $productionjour->getId();
					$item->manoeuvre_id = $value;
					$item->price = $montant / count($datas);
					$item->enregistre();
				}
			}else{
				$datas = MANOEUVRE::findBy(["groupemanoeuvre_id ="=>$groupemanoeuvre_id]);
				foreach ($datas as $key => $value) {
					$item = new MANOEUVREDUJOUR();
					$item->productionjour_id = $productionjour->getId();
					$item->manoeuvre_id = $value->getId();
					$item->price = $montant / count($datas);
					$item->enregistre();
				}
			}

			$productionjour->hydrater($_POST);
			$productionjour->etat_id = ETAT::PARTIEL;
			$productionjour->total_production = $montant;
			$productionjour->employe_id = getSession("employe_connecte_id");
			$data = $productionjour->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas consommé plus de quantité d'une ressource que ce que vous n'en possédez !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez définir les manoeuvres qui ont travaillé aujourd'hui !";
	}
	echo json_encode($data);
}


if ($action == "voirPrixParZone") {
	$params = PARAMS::findLastId();
	include("../../../../composants/assets/modals/modal-prixparzone.php");
}



?>