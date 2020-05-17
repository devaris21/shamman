<?php
namespace Home;
use Native\RESPONSE;
/**
 * 
 */
class SEXE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const HOMME = 1;
	const FEMME = 2;

	public $name;
	public $abreviation;
	public $icon = "fa fa-venus-mars";


	
	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de la nouvelle catégorie";
		}
		return $data;
	}




	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau genre : $this->name dans les paramétrages";
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des propriétés du genre : $this->name.";
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive du genre : $this->name.";
	}
	
}
?>