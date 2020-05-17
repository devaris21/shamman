<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
/**
 * 
 */
class FOURNISSEUR extends AUTH
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const FOURNISSEURSYSTEME = 1;

	public $name;
	public $adresse;
	public $contact;
	public $email;
	public $fax;
	public $description;
	public $acompte = 0;
	public $dette = 0;
	public $image = "default.png";



	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			if ($this->adresse != "" && $this->contact != "") {
				$data = $this->save();
					if ($data->status) {
						$this->uploading($this->files);
						// ob_start();
						// include(__DIR__."/../../sections/home/elements/mails/welcome_prestataire.php");
						// $contenu = ob_get_contents();
						// ob_end_clean();
						// TODO gerer les mails
						//EMAIL::send([$this->email], "Bienvenue - ARTCI | Gestion du parc auto", $contenu);
					}
			}else{
				$data->status = false;
				$data->message = "Veuillez renseigner tous les champs marqués d'un * !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de votre entreprise (votre flotte) !";
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
						$result = $image->upload("images", "fournisseurs", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}




	public function crediter(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			$payement = new OPERATION();
			$payement->hydrater($post);
			if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
				$payement->categorieoperation_id = CATEGORIEOPERATION::APPROVISIONNEMENT;
				$payement->fournisseur_id = $this->getId();
				$payement->comment = "Acréditation du compte du fournisseur ".$this->name()." d'un montant de ".money($montant)." ".$params->devise;
				$data = $payement->enregistre();
				if ($data->status) {
					$id = $data->lastid;
					$this->acompte += intval($montant);
					$data = $this->save();
					$data->setUrl("gestion", "fiches", "boncaisse", $id);
				}
			}else{
				$data->status = false;
				$data->message = "Vous ne pouvez pas choisir ce mode de payement !";
			}			
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function rembourser(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			if ($this->acompte >= intval($montant)) {
				$payement = new OPERATION();
				$payement->hydrater($post);
				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					$payement->categorieoperation_id = CATEGORIEOPERATION::REMBOURSEMENT_FOURNISSEUR;
					$payement->fournisseur_id = $this->getId();
					$payement->comment = "Rembourser à partir du acompte du fournisseur ".$this->name()." d'un montant de ".money($montant)." ".$params->devise."\n ".$_POST["comment1"];
					$data = $payement->enregistre();
					if ($data->status) {
						$id = $data->lastid;
						$this->acompte -= intval($montant);
						$data = $this->save();
						$data->setUrl("gestion", "fiches", "boncaisse", $id);
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas choisir ce mode de payement !";
				}
			}else{
				$data->status = false;
				$data->message = "Le montant à rembourser ne doit pas être supérieur au montant de son acompte!";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function debiter(int $montant){
		$data = new RESPONSE;
		if (intval($montant) > 0 ) {
			if ($this->acompte >= $montant) {
				$this->acompte -= intval($montant);
			}else{
				$this->dette += $montant - $this->acompte;
				$this->acompte = 0;
			}	
			$data = $this->save();	
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}



	public function dette(int $montant){
		$data = new RESPONSE;
		if (intval($montant) > 0 ) {
			$this->dette += intval($montant);
			$data = $this->save();			
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function reglerDette(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			if (intval($montant) <= $this->dette ) {
				$payement = new OPERATION();
				$payement->hydrater($post);

				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE || ($payement->modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE && $montant <= $this->acompte)) {

					if ($payement->modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
						$this->acompte -= intval($montant);
						$this->dette -= intval($montant);
						$data = $this->save();
					}else{
						$this->dette -= intval($montant);
						$payement->categorieoperation_id = CATEGORIEOPERATION::APPROVISIONNEMENT;
						$payement->fournisseur_id = $this->getId();
						$payement->comment = "Reglement de la dette du fournisseur ".$this->name()." d'un montant de ".money($montant)." ".$params->devise;
						$data = $payement->enregistre();
						if ($data->status) {
							$id = $data->lastid;
							$data = $this->save();
							$data->setUrl("gestion", "fiches", "boncaisse", $id);
						}
					}
				}else{
					$data->status = false;
					$data->message = "Le montant sur son acompte est insuffisant pour regler cette somme";
				}	
			}else{
				$data->status = false;
				$data->message = "Le montant à rembourser doit être inférieur à la dette !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}



	public function versements(string $date1 = "2020-04-01", string $date2){
		$datas = $this->fourni("operation", ["DATE(created) >= " => $date1, "DATE(created) <= " => $date2]);
		foreach ($datas as $key => $ope) {
			$ope->actualise();
			if ($ope->categorieoperation->typeoperationcaisse_id != TYPEOPERATIONCAISSE::ENTREE) {
				unset($datas[$key]);
			}
		}
		return comptage($datas, "montant", "somme");
	}




	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau prestataire : $this->name";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du prestataire $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du prestataire $this->id : $this->name";
	}

}



?>