<?php
namespace Home;
use Native\RESPONSE;
/**
 * 
 */
class CONNEXION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $date_connexion;
	public $date_deconnexion ;
	public $employe_id = null;
	public $prestataire_id = null;

	public function enregistre(){
		return $this->save();
	}


	
	//connecter un employé
	public function connexion_employe(){
		$this->deconnexion_employe();
		session("employe_connecte_id", $this->employe_id);
		$this->date_connexion = date("Y-m-d H:i:s");
		$this->date_deconnexion = null;
		$this->enregistre();
	}



	//deconnecter un employé
	public function deconnexion_employe(){
		$datas = CONNEXION::findBy(["employe_id = "=> $this->employe_id], [], ["id"=>"DESC"], 1);
		if (count($datas) > 0) {
			$connexion = $datas[0];
			$connexion->actualise();
			if ($connexion->date_deconnexion == null) {
				$connexion->date_deconnexion = date("Y-m-d H:i:s");
				$connexion->historique("Déconnexion du employe".$connexion->employe->name());
				$connexion->save();
			}
		}
	}



	public static function listeConnecterDuJour(String $date){
		return CONNEXION::execute("SELECT DISTINCT employe_id FROM connexion WHERE DATE(created) = ? ", [$date]);
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////



	public function sentenseCreate(){
		return $this->sentense = "Nouvelle connexion";
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la connexion de ".$this->employe->name()." du ".datelong($this->created);
	}


	public function sentenseDelete(){
		return $this->sentense = "Supprimer de la connexion de  ".$this->employe->name()." du ".datelong($this->created);
	}

}
?>