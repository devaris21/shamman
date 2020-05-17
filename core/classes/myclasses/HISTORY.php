<?php 
namespace Home;
use Native\RESPONSE;
/**
 * 
 */
class HISTORY extends TABLE
{

public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $sentense; // phrase de l'historique
	public $employe_id = null;
	public $carplan_id = null;
	public $prestataire_id = null;
	public $isOperationCaisse = 0; //1 si operation de caisse, 1 sinon
	public $price = 0; //le montant si operation de caisse
	public $typeSave; //-1 delete, 0 create, 1 update
	public $record; //nom de la table
	public $recordId; //id de la table


	public static function createHistory(TABLE $element, String $type_save){
		$sentense = $element->sentense;
		$element->actualise();
		$element->sentense = $sentense;

		extract($element::tableName());
		$story = new HISTORY;
		$story->record = $table;
		$story->record_key = $element->getId();
		$story->type_save = $type_save;
		$story->sentense =  $element->sentense;

		if (getSession("employe_connecte_id") != null) {
			$story->employe_id = getSession("employe_connecte_id");
		}
		if ($story->type_save == "insert") {
			$story->sentense = $element->sentenseCreate();
		}else if ($story->type_save == "delete") {
			$story->sentense = $element->sentenseDelete();
		}else if ($story->type_save == "update") {
			$story->sentense = $element->sentenseUpdate();
		}
		if (isset($element->utilisateur_id)) {
			$story->utilisateur_id = $element->utilisateur_id;
		}
		if (isset($element->carplan_id)) {
			$story->carplan_id = $element->carplan_id;
		}
		if (in_array($story->record, ["depense", "entree", "reglement", "remboursement", "lignefacture"])) {
			$story->isOperationCaisse = 1;
			$story->price = $element->price;
		}
		if ($story->sentense != "") {
			$story->enregistre();
		}
	}
	
	
	public function enregistre(){
		$data = $this->save();
	}


	public function auteur(){
		$this->actualise();
		if ($this->employe_id != null) {
			return $this->employe->name();
			
		}elseif ($this->carplan_id != null) {
			return $this->carplan->name();

		}elseif ($this->prestataire_id != null) {
			return $this->prestataire->name();
		}
	}


	public function type(){
		if ($this->employe_id != null) {
			return "Employe AMB";

		}elseif ($this->utilisateur_id != null) {
			return "Responsable Direction";

		}elseif ($this->carplan_id != null) {
			return "Bénéficiaire Carplan";

		}elseif ($this->prestataire_id != null) {
			return "Prestataire";
		}
	}


	public function typeSave(){
		if ($this->typeSave == -1) {
			return "Insertion";

		}elseif ($this->typeSave == 0) {
			return "Mise à jour";

		}elseif ($this->typeSave == 1) {
			return "Suppression";

		}
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}
?>