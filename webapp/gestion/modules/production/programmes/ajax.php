<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
use Native\ROOTER;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($action == "modifier") {
	session("livraison_id", $id);
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	$datas = LIVRAISON::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		$livraison = $datas[0];
		$livraison->actualise();
		$livraison->fourni("lignelivraison");
		include("../../../../../composants/assets/modals/modal-programmation-modifier.php");
	}
}



if ($action == "modifierProgrammation") {
	if ($datelivraison >= dateAjoute()) {
		if (getSession("livraison_id") != null) {
			$datas = LIVRAISON::findBy(["id ="=>getSession("livraison_id")]);
			if (count($datas) > 0) {
				$livraison = $datas[0];
				$livraison->actualise();
				$livraison->fourni("lignelivraison");


				$produits = explode(",", $tableau);
				if (count($produits) > 0) {
					$tableau = [];
					foreach ($produits as $key => $value) {
						$lot = explode("-", $value);
						$tableau[$lot[0]] = end($lot);
					}
					$test = true;
					foreach ($livraison->lignelivraisons as $key => $ligne) {
						$ligne->actualise();
						$reste = $livraison->groupecommande->reste($ligne->produit->getId()) + $ligne->quantite;
						if ($tableau[$ligne->produit->getId()] <= $reste) { 
							unset($tableau[$ligne->produit->getId()]);
						}
					}
					
					if (count($tableau) == 0) {
						$livraison->hydrater($_POST);
						$livraison->etat_id = ETAT::PARTIEL;
						$data = $livraison->save();
						if ($data->status) {

							$datas = $livraison->fourni("lignelivraison");
							foreach ($datas as $cle => $ligne) {
								$ligne->delete();
							}

							foreach ($produits as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$qte = end($lot);

								$datas = PRODUIT::findBy(["id="=>$id]);
								if (count($datas) > 0) {
									$produit = $datas[0];
									$produit->livrer($qte);

									$lignecommande = new LIGNELIVRAISON;
									$lignecommande->livraison_id = $livraison->getId();
									$lignecommande->produit_id = $id;
									$lignecommande->quantite = $qte;
									$lignecommande->enregistre();
								}
							}

						}	
					}else{
						$data->status = false;
						$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez vérifier la date de programmation de la livraison !";
	}

	echo json_encode($data);
}




if ($action == "valider") {
	session("livraison_id", $id);
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	$datas = LIVRAISON::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		$livraison = $datas[0];
		$livraison->actualise();
		$livraison->fourni("lignelivraison");
		include("../../../../../composants/assets/modals/modal-programmation-valider.php");
	}
}


if ($action == "ValiderLivraisonProgrammee") {
	if (getSession("livraison_id") != null) {
		$datas = LIVRAISON::findBy(["id ="=>getSession("livraison_id")]);
		if (count($datas) > 0) {
			$livraison = $datas[0];
			$livraison->actualise();
			$livraison->fourni("lignelivraison");

			if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
				$avance = 0;
			}

			if ($isLouer == 0 || ((intval($montant_location) - intval($avance) + $groupecommande->client->dette) <= $params->seuilCredit)) {


				$produits = explode(",", $tableau);
				if (count($produits) > 0) {
					$tableau = [];
					foreach ($produits as $key => $value) {
						$lot = explode("-", $value);
						$tableau[$lot[0]] = end($lot);
					}
					$test = true;
					foreach ($livraison->lignelivraisons as $key => $ligne) {
						$ligne->actualise();
						$reste = $livraison->groupecommande->reste($ligne->produit->getId()) + $ligne->quantite;
						$qte = $tableau[$ligne->produit->getId()];
						if ($qte <= $reste && $qte <= $ligne->produit->livrable()) { 
							unset($tableau[$ligne->produit->getId()]);
						}
					}

					if (count($tableau) == 0) {
						if ($vehicule_id <= VEHICULE::TRICYCLE) {
							$_POST["chauffeur_id"] = 0;
						}
						$livraison->hydrater($_POST);
						$livraison->etat_id = ETAT::ENCOURS;
						$livraison->datelivraison = null;
						$data = $livraison->enregistre();
						if ($data->status) {
							$datas = $livraison->fourni("lignelivraison");
							foreach ($datas as $cle => $ligne) {
								$ligne->delete();
							}

							foreach ($produits as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$qte = end($lot);

								$datas = PRODUIT::findBy(["id="=>$id]);
								if (count($datas) > 0) {
									$produit = $datas[0];
									$produit->livrer($qte);

									$lignecommande = new LIGNELIVRAISON;
									$lignecommande->livraison_id = $livraison->getId();
									$lignecommande->produit_id = $id;
									$lignecommande->quantite = $qte;
									$lignecommande->enregistre();
								}
							}

							if ($vehicule_id != VEHICULE::AUTO && $vehicule_id != VEHICULE::TRICYCLE) {
								$datas = VEHICULE::findBy(["id="=>$vehicule_id]);
								if (count($datas) > 0) {
									$vehicule = $datas[0];
									$vehicule->etatvehicule_id = ETATVEHICULE::MISSION;
									$vehicule->save();
								}

								if($isLouer == 1 && $montant_location > 0 ){
									if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
										$lot = $client->debiter($montant_location);

									}else{

										if ($montant_location > intval($avance)) {
											$client->dette($montant_location - intval($avance));
										}

										$livraison->actualise();
										$payement = new OPERATION();
										$payement->hydrater($_POST);
										$payement->categorieoperation_id = CATEGORIEOPERATION::LOCATION_LIVRAISON;
										$payement->montant = $avance;
										$payement->client_id = $livraison->groupecommande->client_id;
										$payement->comment = "Réglement pour la location d'engins de livraison pour la livraison N°".$livraison->reference;
										$lot = $payement->enregistre();

										$livraison->operation_id = $lot->lastid;
									}


								}
							}

							$data = $livraison->save();
							$data->setUrl("gestion", "fiches", "bonlivraison", $data->lastid);			
						}	
					}else{
						$data->status = false;
						$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
				}
			}else{
				$data->status = false;
				$data->message = "Le seuil de credit pour ce client sera dépassé !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
	}

	echo json_encode($data);
}
