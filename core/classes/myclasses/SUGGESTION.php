<?php
namespace Home;
use Native\RESPONSE;
use Native\FICHIER;
/**
 * 
 */
class SUGGESTION extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $ticket;
	public $typesuggestion_id;
	public $title;
	public $description;
	public $gestionnaire_id = null;
	public $utilisateur_id = null;
	public $carplan_id = null;
	public $prestataire_id = null;
	public $etat_id = ETAT::ENCOURS;
	public $date_approuve;



	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du produit !";
		}
		return $data;
	}


	public function auteur(){
		$this->actualise();
		if ($this->gestionnaire_id != null) {
			return $this->gestionnaire->name();

		}else if ($this->carplan_id != null) {
			return $this->carplan->name();

		}else if ($this->utilisateur_id != null) {
			return $this->utilisateur->name();

		}else if ($this->prestataire_id != null) {
			return $this->prestataire->name();
		}
	}	

	public function emoji(){
		//critique
		if ($this->typesuggestion_id == 1) {
			return "💢";

		//derangeant
		}else if ($this->typesuggestion_id == 2) {
			return "🤕";

		//
		}else if ($this->typesuggestion_id == 3) {
			return "😓";

		//suggestion
		}else if ($this->typesuggestion_id == 4) {
			return "☹";
		}
	}




	public function approuver(){
		$data = new RESPONSE;
		$rooter = new ROOTER;
		$this->etat_id = ETAT::VALIDEE;
		$this->date_approuve = date("Y-m-d H:i:s");
		$this->historique("Approbation de la demande d'entretien de véhicule N° $this->id");
		$data = $this->save();
		if ($data->status) {
			$this->actualise();
			$message = "Votre declaration de sinistre pour la ".$this->vehicule->marque->name." ".$this->vehicule->modele." immatriculé ".$this->vehicule->immatriculation." a bien été prise en compte et approuver par la gestion du parc automobile de l'ARTCI !";
			$image = $rooter->stockage("images", "vehicules", $this->vehicule->image);
			$objet = "Déclaration de sinistre approuvée";

			ob_start();
			include(__DIR__."/../../sections/home/elements/mails/sinistre.php");
			$contenu = ob_get_contents();
			ob_end_clean();
			// TODO gerer les emails
			//EMAIL::send([$this->email()], $objet, $contenu);
			session("sinistre", $this);
		}
		return $data;
	}




	public function sentenseCreate(){
		return $this->sentense = "Enregistrement d'un nouveau equipement $this->name .";
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des infos de l'equipement N°$this->id  $this->name .";
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive de l'equipement $this->name  dans la base de données.";
	}

}



?>