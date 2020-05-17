<?php
namespace Home;
use Native\RESPONSE;
use Native\FICHIER;
/**
 * 
 */
class MACHINE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $marque;
	public $image = "default.jpg";
	public $modele;
	public $etatvehicule_id =  ETATVEHICULE::RAS;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "" && $this->marque != "") {
			$data = $this->save();
			if ($data->status) {
				$this->uploading($this->files);
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner tous les champs !";
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
						$result = $image->upload("images", "machines", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}




////////////////////////////////////////////////////////////////////////////


	public static function ras(){
		return static::findBy(["etatvehicule_id ="=> ETATVEHICULE::RAS]);
	}

	public static function mission(){
		return static::findBy(["etatvehicule_id ="=> ETATVEHICULE::MISSION]);
	}

	public static function entretien(){
		return static::findBy(["etatvehicule_id !="=> - ETATVEHICULE::ENTRETIEN]);
	}


////////////////////////////////////////////////////////////////////////////////////////////////////
/// 
/// 
	public function sentenseCreate(){
		return $this->sentense = "Enregistrement d'un nouveau machine ".$this->name();
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des infos du machine N°$this->id ". $this->name();
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive du machine N°$this->id ". $this->name();
	}

}
?>