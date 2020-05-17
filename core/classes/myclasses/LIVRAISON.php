<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class LIVRAISON extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $groupecommande_id;
	public $zonelivraison_id;
	public $lieu;
	public $vehicule_id;
	public $chauffeur_id = 0;
	public $etat_id = ETAT::ENCOURS;
	public $employe_id = 0;
	
	public $isLouer = 0;
	public $montant_location = 0;
	public $operation_id = 0;
	public $nom_tricycle = "";
	public $paye_tricycle = 0;
	public $reste = 0;
	public $chargement_manoeuvre;
	public $dechargement_manoeuvre;
	public $isPayer = 0;

	public $datelivraison;
	public $comment;
	public $nom_receptionniste;
	public $contact_receptionniste;

	

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->lieu != "") {
			$datas = ZONELIVRAISON::findBy(["id ="=>$this->zonelivraison_id]);
			if (count($datas) == 1) {
				$datas = VEHICULE::findBy(["id ="=>$this->vehicule_id]);
				if (count($datas) == 1) {
					if ($this->vehicule_id == VEHICULE::AUTO || ($this->vehicule_id == VEHICULE::TRICYCLE && $this->nom_tricycle != "" && $this->paye_tricycle > 0) || ($this->vehicule_id > VEHICULE::TRICYCLE && $this->chauffeur_id > 0)) {

						if (($this->vehicule_id <= VEHICULE::TRICYCLE) || ($this->vehicule_id > VEHICULE::TRICYCLE && $this->isLouer == 0) || ($this->vehicule_id > VEHICULE::TRICYCLE && $this->isLouer == 1 && $this->montant_location > 0)) {
							
							$this->employe_id = getSession("employe_connecte_id");
							$this->reference = "BLI/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
							$this->reste = $this->paye_tricycle;
							$data = $this->save();

						}else{
							$data->status = false;
							$data->message = "Veuillez renseigner le montant de la location ";
						}
					}else{
						$data->status = false;
						$data->message = "Veuillez renseigner tous les champs pour valider la livraison !";
					}
				}else{
					$data->status = false;
					$data->message = "veuillez selectionner un véhicule pour la livraison!";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'enregistrement de la livraison!";
			}
		}else{
			$data->status = false;
			$data->message = "veuillez indiquer la destination précise de la livraison *!";
		}
		return $data;
	}



	//les livraions programmées du jour
	public static function programmee(String $date){
		return static::findBy(["DATE(datelivraison) ="=>$date, "etat_id !="=>ETAT::ANNULEE]);
	}


	//les livraions effectuéez du jour
	public static function effectuee(String $date){
		return static::findBy(["DATE(datelivraison) ="=>$date, "etat_id ="=>ETAT::VALIDEE]);
	}


	// Supprimer toutes les livraisons programmée qui n'ont pu etre effectuée...
	public static function ResetProgramme(){
		$datas = LIVRAISON::findBy(["etat_id ="=>ETAT::PARTIEL, "DATE(datelivraison) <"=>dateAjoute()]);
		foreach ($datas as $key => $livraison) {
			$livraison->fourni("lignelivraison");
			foreach ($livraison->lignelivraisons as $key => $value) {
				$value->delete();
			}
			$livraison->delete();
		}
		
		// $requette = "DELETE FROM livraison WHERE etat_id = ? AND DATE(datelivraison) < ? ";
		// static::query($requette, [ETAT::PARTIEL, dateAjoute()]);
	}


	public function chauffeur(){
		if ($this->vehicule_id == VEHICULE::AUTO) {
			return "...";
		}else if ($this->vehicule_id == VEHICULE::TRICYCLE) {
			return $this->nom_tricycle;
		}else{
			return $this->chauffeur->name();
		}
	}


	public function vehicule(){
		if ($this->vehicule_id == VEHICULE::AUTO) {
			return "SON PROPRE VEHICULE";
		}else if ($this->vehicule_id == VEHICULE::TRICYCLE) {
			return "TRICYCLE";
		}else{
			return $this->vehicule->name();
		}
	}



	public function annuler(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::ANNULEE;
			$this->historique("La livraison en reference $this->reference vient d'être annulée !");
			$data = $this->save();
			if ($data->status) {
				$this->actualise();
				$this->groupecommande->etat_id = ETAT::ENCOURS;
				$this->groupecommande->save();

				if ($this->chauffeur_id > 0) {
					$this->chauffeur->etatchauffeur_id = ETATCHAUFFEUR::RAS;
					$this->chauffeur->save();
				}

				$this->vehicule->etat_id = ETATVEHICULE::RAS;
				$this->vehicule->save();
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cette livraison !";
		}
		return $data;
	}



	public function terminer(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::VALIDEE;
			$this->datelivraison = date("Y-m-d H:i:s");
			$this->historique("La livraison en reference $this->reference vient d'être terminé !");
			$data = $this->save();
			if ($data->status) {
				$this->actualise();
				if ($this->chauffeur_id > 0) {
					$this->chauffeur->etatchauffeur_id = ETATCHAUFFEUR::RAS;
					$this->chauffeur->save();
				}

				$this->vehicule->etatvehicule_id = ETATVEHICULE::RAS;
				$this->vehicule->save();

				$this->groupecommande->etat_id = ETAT::ENCOURS;
				$this->groupecommande->save();
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cette livraison !";
		}
		return $data;
	}



	public static function perte(string $date1, string $date2){
		$total = 0;
		$datas = LIVRAISON::findBy(["etat_id ="=>ETAT::VALIDEE, "DATE(datelivraison) >= " => $date1, "DATE(datelivraison) <= " => $date2]);
		foreach ($datas as $key => $livraison) {
			$lots = $livraison->fourni("lignelivraison");
			foreach ($lots as $key => $ligne) {
				$total += $ligne->quantite - $ligne->quantite_livree;
			}
		}
		return $total;
	}




	public function payer(int $montant, Array $post){
		$data = new RESPONSE;
		$solde = $this->reste;
		if ($solde > 0) {
			if ($solde >= $montant) {
				$payement = new OPERATION();
				$payement->hydrater($post);
				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					$payement->categorieoperation_id = CATEGORIEOPERATION::PAYE_TRICYLE;
					$payement->manoeuvre_id = $this->getId();
					$payement->comment = "Réglement de la paye de tricycle ".$this->chauffeur()." pour la commande N°".$this->reference;
					$data = $payement->enregistre();
					if ($data->status) {
						$this->reste -= $montant;
						$this->isPayer = 1;
						$data = $this->save();
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement pour effectuer cette opération !";
				}
			}else{
				$data->status = false;
				$data->message = "Le montant à verser est plus élévé que sa paye !";
			}
		}else{
			$data->status = false;
			$data->message = "Vous etes déjà à jour pour la paye de ce tricycle !";
		}
		return $data;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>