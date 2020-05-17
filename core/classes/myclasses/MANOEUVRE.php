<?php
namespace Home;
use Native\RESPONSE;
use Native\FICHIER;
use \DateTime;
use \DateInterval;
/**
/**
 * 
 */
class MANOEUVRE extends PERSONNE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $groupemanoeuvre_id;
	public $name;
	public $adresse;
	public $contact;
	public $image = "default.png";



	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name ) {
			$data = $this->save();
			if ($data->status) {
				$this->uploading($this->files);
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez le login et le mot de passe du nouvel employé !";
		}
		return $data;
	}



	public function uploading(Array $files){
		//les proprites d'images;
		$tab = ["image"];
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if ($file["tmp_name"] != "") {
					$image = new FICHIER();
					$image->hydrater($file);
					if ($image->is_image()) {
						$a = substr(uniqid(), 5);
						$result = $image->upload("images", "manoeuvres", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}


	public function solde(){
		$total = 0;
		$datas = $this->fourni("manoeuvredujour");
		$total += comptage($datas, 'price', "somme");

		$datas = $this->fourni("operation", ["categorieoperation_id ="=> CATEGORIEOPERATION::PAYE]);
		$total -= comptage($datas, 'montant', "somme");
		return $total;
	}


	public function payer(int $montant, Array $post){
		$data = new RESPONSE;
		$solde = $this->solde();
		if ($solde > 0) {
			if ($solde >= $montant) {
				if ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					$payement->hydrater($post);
					$payement = new OPERATION();
					$payement->categorieoperation_id = CATEGORIEOPERATION::PAYE;
					$payement->manoeuvre_id = $this->getId();
					$payement->comment = "Réglement de la paye de ".$this->name();
					$data = $payement->enregistre();
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
			$data->message = "Vous etes déjà à jour pour la paye de ce manoeuvre !";
		}
		return $data;
	}



	public static function reste_paye(){
		$total = 0;
		foreach (static::getAll() as $key => $man) {
			$total += $man->solde();
		}
		return $total;
	}




	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau chauffeur dans votre gestion : $this->name $this->lastname";
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du chauffeur N°$this->id : $this->name $this->lastname.";
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive du chauffeur N°$this->id : $this->name $this->lastname.";
	}



}

?>