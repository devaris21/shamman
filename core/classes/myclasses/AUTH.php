<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\SHAMMAN;
/**
 * 
 */
abstract class AUTH extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $nationalite;
	public $adresse;
	public $date_naissance;
	public $lieu_naissance;
	public $contact;
	public $contact2;
	public $ville;

	public $login;
	public $password;


	public static function connect(Array $params){
		$data = new RESPONSE;
		if (count($params) > 0) {
			$datas = static::findBy($params);
			if (count($datas) == 1) {
				$element = $datas[0];
				$element->actualise();
				if ($element->is_allowed()) {
					$data->status = true;
					//on met a jour le lasttime
					session("last_access", time());
					$data->element = $element;
					$data->new = false;
					if ($element->is_new == 1) {
						$data->new = true;
					}
				}else{
					$data->status = false;
					$data->message = "L'accès à cette application vous a été restrient ! <br> Veuillez contacter votre Administrateur.";
					$data->setUrl("access", "restriction");
				}
			}else{
				$data->status = false;
				$data->message = "Votre login et/ou le mot de passe est incorrect !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner integralement vos parametres de connexion !";
		}
		return $data;
	}


	public function is_allowed(){
		if ($this->is_allowed == 0) {
			return false;
		}else{
			return true;
		}
	}

	public function is_new(){
		if ($this->is_new == 1) {
			return false;
		}else{
			return true;
		}
	}



	public function lock(){
		$this->is_allowed = 0;
		$this->historique("Restriction des accès pour ".$this->name());
		return $this->save();
	}


	public function unlock(){
		$this->is_allowed = 1;
		$this->historique("Deblocage des accès pour ".$this->name());
		return $this->save();
	}




	public function resetPassword(){
		$this->is_new = 1;
		$this->login = substr(uniqid(), 6);
		$this->pass = $pass = substr(uniqid(), 6);
		$this->password = hasher($pass);
		$this->historique("Reinitialisation des parametres de connexion de ".$this->name());
		$data = $this->save();
		// if ($data->status && false) {
		// 	ob_start();
		// 	//TODO mettre le mail a jour
		// 	include(__DIR__."/../../../composants/assets/mails/reset.php");
		// 	$contenu = ob_get_contents();
		// 	ob_end_clean();
		// 	EMAIL::send([$this->email], "Reinitialisation de vos parametres de connexion", $contenu);
		// 	$data->setUrl("amb", "start", "select");
		// }
		return $data;
	}



	public function loginIsValide(String $login){
		if ($login != "") {
			$login = verification($login);
			$datas = static::findBy(["login = "=>$login]);
			if (count($datas) == 0) {
				return true;
			}else{
				$item = $datas[0];
				if ($item->id === $this->id) {
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}


	public function emailIsValide(){
		if(filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$datas = static::findBy(["email = "=>$this->email]);
			if (count($datas) == 0) {
				return true;
			}else{
				$item = $datas[0];
				if ($item->id === $this->id) {
					return true;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}



	public function passwordIsValide($password){
		return (strlen($password) > 6);
	}



	public function checkPassword($password){
		return ($this->password === hasher($password));
	}


	public function setLogin($login){
		if ($login != "") {
			$login = verification($login);
			$datas = static::findBy(["login = "=>$login]);
			if (count($datas) == 0) {
				$this->login = $login;
				return true;
			}else{
				$gestionnaireTemp = $datas[0];
				if ($gestionnaireTemp->id === $this->id) {
					$this->login = $login;
					return true;
				}else{
					$this->login = null;
					return false;
				}
			}
		}else{
			return false;
		}
	}


	public function setPassword($password){
		$this->password = hasher($password);
		return $this;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>