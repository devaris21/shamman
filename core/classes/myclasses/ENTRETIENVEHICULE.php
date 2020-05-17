<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
use Native\ROOTER;



/**
 * 
 */
class ENTRETIENVEHICULE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $reference;
	public $typeentretienvehicule_id;
	public $demandeentretien_id = null;
	public $name;
	public $vehicule_id;
	public $prestataire_id;
	public $price;
	public $started;
	public $finished;
	public $employe_id;
	public $etat_id = ETAT::ENCOURS;
	public $date_approuve; 
	public $image; 
	public $comment; 



	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEENTRETIENVEHICULE::findBy(["id ="=>$this->typeentretienvehicule_id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			$this->name = $item->name;
			$datas = VEHICULE::findBy(["id ="=>$this->vehicule_id]);
			if (count($datas) == 1) {
				$this->reference = strtoupper(substr(uniqid(), 5, 6));
				$this->demandeentretien_id = getSession("demandeentretien_id");
				$this->employe_id = getSession("employe_connecte_id");
				$data = $this->save();
				if ($data->status) {
					$this->uploading($this->files);
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération b, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération n, veuillez recommencer !";
		}		
		return $data;
	}



	public function uploading(Array $files){
		//les proprites d'images;
		$tab = ["image1", "image2"];
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if ($file["tmp_name"] != "") {
					$image = new FICHIER();
					$image->hydrater($file);
					if ($image->is_image()) {
						$a = substr(uniqid(), 5);
						$result = $image->upload("images", "entretienvehicules", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// 

	public static function commencerCeMois(){
		return static::findBy(["started >="=>date("Y-m")."-01", "started < "=>date("Y")."-".(date("m")+1)."-01"]);
	}

	public static function annuleesCeMois(){
		return static::findBy(["etat_id ="=>ETAT::ANNULEE, "date_approuve >="=>date("Y-m")."-01"]);
	}

	public static function coutAnnuel(){
		return comptage(static::findBy(["DATE(started) >= "=> date("Y")."-01-01"]), "price", "somme");
	}



	public static function jour($date){
		return static::findBy(["etat_id !="=>ETAT::ANNULEE, "DATE(created) ="=>$date]);
	}


	public function approuver(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::VALIDEE;
			$this->date_approuve = date("Y-m-d H:i:s");
			$this->historique("Succès de l'entretien du vehicule N° ".$this->vehicule->name);
			$data = $this->save();

			$this->actualise();
			$this->vehicule->etatvehicule_id = ETATVEHICULE::RAS;
			$this->vehicule->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas effectuer cette action sur cet element !";
		}
		return $data;
	}
	


	public function annuler(){
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::ANNULEE;
			$this->historique("Annulation de l'entretien du vehicule N° $this->reference");
			$data = $this->save();

			$this->actualise();
			$this->vehicule->etatvehicule_id = ETATVEHICULE::RAS;
			$this->vehicule->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas effectuer cette action sur cet element !";
		}
	}





	public static function encours(){
		return static::findBy(["etat_id ="=>ETAT::ENCOURS]);
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>