<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ZONELIVRAISON extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				foreach (PRODUIT::getAll() as $key => $produit) {
					$ligne = new PRIX_ZONELIVRAISON();
					$ligne->zonelivraison_id = $data->lastid;
					$ligne->produit_id = $produit->getId();
					$ligne->price = 0;
					$ligne->enregistre();
				}
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de la zone de livraison !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'une nouvelle zone de livraison : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la zone de livraison $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la zone de livraison $this->id : $this->name";
	}


}
?>