<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
/**
 * 
 */
class PRESTATAIRE extends AUTH
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const PRESTATAIRESYSTEME = 1;

	public $name;
	public $typeprestataire_id = 1;
	public $login;
	public $password;
	public $adresse;
	public $contact;
	public $email;
	public $fax;
	public $registre;
	public $image = "default.png";

	public $is_new = 1;
	public $is_allowed = 1;




	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			if ($this->adresse != "" && $this->contact != "") {
				if ($this->emailIsValide($this->email)) {
					$pass = substr(uniqid(), 5);
					$this->login = substr(uniqid(), 5);
					$this->password = hasher($pass);
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
					$data->message = "Veuillez changer votre adresse email !";
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
						$result = $image->upload("images", "prestataires", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}



	public function se_connecter(){
		$connexion = new CONNEXION;
		$connexion->prestataire_id = $this->getId();
		$connexion->connexion_prestataire();
	}



	public function se_deconnecter(){
		$connexion = new CONNEXION;
		$connexion->prestataire_id = $this->getId();
		$connexion->deconnexion_prestataire();
	}


	public function last_connexion(){
		$datas = CONNEXION::findBy(["prestataire_id = "=> $this->getId()], [], ["id"=>"DESC"], 1);
		if (count($datas) == 1) {
			$connexion = $datas[0];
			if ($connexion->date_deconnexion == null) {
				return date("Y-m-d H:i:s");
			}else{
				return $connexion->date_deconnexion;
			}
		}
	}




	public function produits(){
		return PRODUIT::findBy(["prestataire_id !="=> $this->getId(), "typeproduit_id ="=>1]);
	}

	public function services(){
		return PRODUIT::findBy(["prestataire_id !="=> $this->getId(), "typeproduit_id ="=>2]);
	}

	public function vehicules(){
		return PRODUIT::findBy(["prestataire_id !="=> $this->getId(), "typeproduit_id ="=>3]);
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