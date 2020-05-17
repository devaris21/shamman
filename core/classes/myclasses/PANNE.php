<?php
namespace Home;
use Native\RESPONSE;
use Native\ROOTER;
use Native\EMAIL;
use Native\FICHIER;


/**
 * 
 */
class PANNE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $reference;
	public $title;
	public $machine_id	;
	public $manoeuvre_id = null;
	public $comment;
	public $image;
	public $date_approuve;

	public $etat_id = ETAT::ENCOURS;
	public $employe_id;


	public function enregistre(){
		$data = new RESPONSE;
		$this->machine_id = getSession("machine_id");
		$datas = MACHINE::findBy(["id ="=>$this->machine_id]);
		if (count($datas) == 1) {
			$this->reference = strtoupper(substr(uniqid(), 5, 6));
			$data = $this->save();
			if ($data->status) {
				$this->actualise();
				$this->machine->etatvehicule_id = ETATVEHICULE::ENTRETIEN;
				$this->machine->save();
				
				$this->uploading($this->files);
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
						$result = $image->upload("images", "pannes", $a);
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

	public static function valideesCeMois(){
		return static::findBy(["etat_id ="=>ETAT::VALIDEE, "date_approuve >="=>date("Y-m")."-01"]);
	}

	public static function annuleesCeMois(){
		return static::findBy(["etat_id ="=>ETAT::ANNULEE, "date_approuve >="=>date("Y-m")."-01"]);
	}




	public function annuler(){
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::ANNULEE;
			$this->historique("Annulation de la declaration de panne");
			$data = $this->save();

			$this->actualise();
			$this->machine->etatvehicule_id = ETATVEHICULE::RAS;
			$this->machine->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas effectuer cette action sur cet element !";
		}
	}


	public function approuver(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->actualise();
			$this->etat_id = ETAT::VALIDEE;
			$this->date_approuve = date("Y-m-d H:i:s");
			$this->historique("Approbation pour la panne de la machine N° ".$this->machine->name);
			$data = $this->save();

			$this->actualise();
			$this->machine->etatvehicule_id = ETATVEHICULE::RAS;
			$this->machine->save();
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez pas effectuer cette action sur cet element !";
		}
		return $data;
	}
	

	public static function jour($date){
		return static::findBy(["etat_id !="=>ETAT::ANNULEE, "DATE(created) ="=>$date]);
	}


	public function sentenseCreate(){
		return $this->sentence = "Enregistrement d'une nouvelle panne de machine pour ".$this->machine->name()." mis en cause ".$this->manoeuvre->name();
	}

	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>