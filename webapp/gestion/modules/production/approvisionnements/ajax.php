<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
use Native\ROOTER;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
			$ressource = $datas[0]; ?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeRessource(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td >
					<img style="width: 40px" src="<?= $rooter->stockage("images", "ressources", $ressource->image) ?>">
				</td>
				<td class="text-left">
					<h4 class="mp0 text-uppercase"><?= $ressource->name() ?></h4>
					<small><?= $ressource->unite ?></small>
				</td>
				<td width="90">
					<label>Quantité</label>
					<input type="text" number name="quantite" class="form-control text-center gras" value="1" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $ressource->abbr ?></td>
				<td width="120">
					<label>Prix d'achat</label>
					<input type="text" number name="prix" class="form-control text-center gras prix" value="1" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $params->devise  ?></td>
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


if ($action == "calcul") {
	$params = PARAMS::findLastId();
	$rooter = new ROOTER;
	$total = 0;
	$ressources = explode(",", $tableau);
	foreach ($ressources as $key => $value) {
		$lot = explode("-", $value);
		$id = $lot[0];
		$qte = 0;
		if (isset($lot[1])) {
			$qte = $lot[1];
		};
		$prix = end($lot);
		$datas = RESSOURCE::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$ressource = $datas[0];
			$total += $prix; ?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeRessource(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td >
					<img style="width: 40px" src="<?= $rooter->stockage("images", "ressources", $ressource->image) ?>">
				</td>
				<td class="text-left">
					<h4 class="mp0 text-uppercase"><?= $ressource->name() ?></h4>
					<small><?= $ressource->description ?></small>
				</td>
				<td width="90">
					<label>Quantité</label>
					<input type="text" number name="quantite" class="form-control text-center gras" value="<?= $qte ?>" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $ressource->abbr  ?></td>
				<td width="120">
					<label>Prix d'achat</label>
					<input type="text" number name="prix" class="form-control text-center gras prix" value="<?= $prix ?>" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $params->devise  ?></td>
			</tr>
			<?php
		}
	}

	session("total", $total);
}


if ($action == "total") {
	$params = PARAMS::findLastId();
	$data = new \stdclass();
	$data->total = money(getSession("total"))." ".$params->devise;
	echo json_encode($data);
}





if ($action == "validerApprovisionnement") {
	if (isset($fournisseur_id) && $fournisseur_id != "") {
		$datas = FOURNISSEUR::findBy(["id ="=>$fournisseur_id]);
		if (count($datas) == 1) {
			$fournisseur = $datas[0];

			$ressources = explode(",", $tableau);
			if (count($ressources) > 0) {
				$tests = $ressources;
				foreach ($tests as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$qte = 0;
					if (isset($lot[1])) {
						$qte = $lot[1];
					};
					$prix = end($lot);
					if ($qte > 0) {
						unset($tests[$key]);
					}
				}


				$approvisionnement = new APPROVISIONNEMENT();
				if (count($tests) == 0) {

					$total = getSession("total");
					$data->status = true;
					$data->lastid = null;

					if (intval($total) > 0) {
						if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
							if ($fournisseur->acompte >= $total) {
								$approvisionnement->avance = $total;
							}else{
								$approvisionnement->avance = $fournisseur->acompte;
							}
							$data = $fournisseur->debiter($total);

						}else{

							if ($total > intval($avance)) {
								$fournisseur->dette($total - intval($avance));
							}

							$payement = new OPERATION();
							$payement->hydrater($_POST);
							$payement->categorieoperation_id = CATEGORIEOPERATION::APPROVISIONNEMENT;
							$payement->montant = $avance;
							$payement->fournisseur_id = $fournisseur_id;
							$data = $payement->enregistre();

							$approvisionnement->operation_id = $data->lastid;

							$fournisseur->actualise();
							$payement->acompteClient = $fournisseur->acompte;
							$payement->detteClient = $fournisseur->dette;
							$data = $payement->save();
						}
					}

					if ($data->status) {

						$approvisionnement->hydrater($_POST);
						if ($approvisionnement->etat_id == ETAT::VALIDEE) {
							$approvisionnement->datelivraison = date("Y-m-d H:i:s");
						}
						$approvisionnement->montant = $total;
						$data = $approvisionnement->enregistre();
						if ($data->status) {
							foreach ($ressources as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$qte = $lot[1];
								$prix = end($lot);
								$datas = RESSOURCE::findBy(["id ="=> $id]);
								if (count($datas) == 1) {
									$ressource = $datas[0];
									$lignecommande = new LIGNEAPPROVISIONNEMENT;
									$lignecommande->approvisionnement_id = $approvisionnement->getId();
									$lignecommande->ressource_id = $id;
									$lignecommande->quantite = $qte;
									$lignecommande->price =  $prix;
									$lignecommande->enregistre();	
								}
							}

							if ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE && $total > 0) {
								$payement->comment = "Réglement de la facture d'approvisionnement N°".$approvisionnement->reference;
								$data = $payement->save();
								$data->setUrl("gestion", "fiches", "boncaisse", $data->lastid);
							}
						}
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez selectionner des ressources et leur quantité pour passer la commande !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez selectionner des ressources et leur quantité pour passer la commande !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez selectionner un fournisseur pour passer la commande !";
	}
	
	echo json_encode($data);
}




if ($action == "annuler") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = APPROVISIONNEMENT::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$approvisionnement = $datas[0];
				$data = $approvisionnement->annuler();
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




if ($action == "validerAppro") {
	$id = getSession("approvisionnement_id");
	$datas = APPROVISIONNEMENT::findBy(["id ="=>$id]);
	if (count($datas) > 0) {
		$appro = $datas[0];
		$appro->fourni("ligneapprovisionnement");

		$ressources = explode(",", $tableau);
		if (count($ressources) > 0) {
			$tests = $ressources;
			foreach ($tests as $key => $value) {
				$lot = explode("-", $value);
				$id = $lot[0];
				$qte = end($lot);
				foreach ($appro->ligneapprovisionnements as $key => $lgn) {
					if (($lgn->ressource_id == $id) && ($lgn->quantite >= $qte)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				$appro->hydrater($_POST);
				$data = $appro->terminer();
				if ($data->status) {
					foreach ($ressources as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);
						foreach ($appro->ligneapprovisionnements as $key => $lgn) {
							if ($lgn->ressource_id == $id) {
								$lgn->quantite_recu = $qte;
								$lgn->save();
								break;
							}
						}
					}
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}