<?php
namespace Home;
use Native\RESPONSE;
use Native\ROOTER;
use Native\EMAIL;
use Native\FICHIER;


/**
 * 
 */
class DEMANDEENTRETIEN extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $reference;
	public $typeentretienvehicule_id;
	public $chauffeur_id = null;
	public $vehicule_id	;
	public $comment;
	public $image;
	public $date_approuve;

	public $etat_id = ETAT::ENCOURS;
	public $employe_id;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEENTRETIENVEHICULE::findBy(["id ="=>$this->typeentretienvehicule_id]);
		if (count($datas) == 1) {
			$this->vehicule_id = getSession("vehicule_id");

			$this->reference = strtoupper(substr(uniqid(), 5, 6));
			$this->employe_id = getSession("employe_connecte_id");
			$data = $this->save();
			if ($data->status) {
				$this->uploading($this->files);
				
				$this->actualise();
				$this->vehicule->etatvehicule_id = ETATVEHICULE::ENTRETIEN;
				$this->vehicule->save();

				$data->message = "Votre demande d'entretien du véhicule a été enregistré avec succes !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
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
						$result = $image->upload("images", "demandeentretiens", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}




	public static function encours(){
		return static::findBy(["etat_id ="=>ETAT::ENCOURS]);
	}

	public static function jour($date){
		return static::findBy(["etat_id !="=>ETAT::ANNULEE, "DATE(created) ="=>$date]);
	}

	public static function annuleesCeMois(){
		return static::findBy(["etat_id ="=>ETAT::ANNULEE, "date_approuve >="=>date("Y-m")."-01"]);
	}





	public function annuler(){
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::ANNULEE;
			$this->historique("Annulation de la demande d'entretien de véhicule N° ".$this->vehicule->name());
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


	public function approuver(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::VALIDEE;
			$this->date_approuve = date("Y-m-d H:i:s");
			$this->historique("Approbation de la demande d'entretien de véhicule N° ".$this->vehicule->name());
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
	




	public function sentenseCreate(){
		return $this->sentence = "Enregistrement d'une nouvelle demande d'entretien de vehicule pour le vehicule ".$this->vehicule->name()." par ".$this->carplan->name();
	}

	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>