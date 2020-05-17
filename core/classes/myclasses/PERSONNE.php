<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;

/**
/**
 * 
 */
abstract class PERSONNE extends TABLE
{
	public $name;
	public $lastname;
	public $nationalite;
	public $adresse;
	public $date_naissance;
	public $lieu_naissance;
	public $contact;
	public $contact2;
	public $ville;

	public $login;
	public $password;


	// public static function authentification(string $login, string $password){
	// 	$data = new RESPONSE;
	// 	if ($password != "" && $login != "") {
	// 		//on essaie la connexion normale
	// 		$datas = static::findBy(["login = "=> $login, "password = "=>hasher($password)]);
	// 		if (count($datas) == 1) {
	// 			$element = $datas[0];
	// 			$element->actualise();
	// 			if ($element->is_allowed()) {
	// 				$data->status = true;
	// 				//on met a jour le lasttime
	// 				session("last_access", time());
	// 				$data->element = $element;
	// 				$data->new = false;
	// 				if ($element->is_new == 1) {
	// 					$data->new = true;
	// 				}
	// 			}else{
	// 				$data->status = false;
	// 				$data->message = "L'accès à cette application vous a été restrient !";
	// 				$data->setUrl("access", "restriction");
	// 			}
	// 		}else{
	// 			//on verifie dans active directory
	// 			$ldapconn = ldap_connect("ldap://172.16.0.3");
	// 			if ($ldapconn) {
	// 				$ldapbind = @ldap_bind($ldapconn, $login, $password);
	// 				if ($ldapbind) {
	// 					//on essaie la connexion normale
	// 					$datas = static::findBy(["email = "=> $login]);
	// 					if (count($datas) == 1) {
	// 						$element = $datas[0];
	// 						$element->actualise();
	// 						if ($element->is_allowed()) {
	// 							$data->status = true;
	// 						//on met a jour le lasttime
	// 							session("last_access", time());
	// 							$data->element = $element;
	// 							$data->new = false;
	// 						}else{
	// 							$data->status = false;
	// 							$data->message = "L'accès à cette application vous a été restrient !";
	// 							$data->setUrl("access", "restriction");
	// 						}
	// 					} else {
	// 						$data->status = false;
	// 						$data->message = "Votre login/email et/ou le mot de passe est incorrect !";
	// 					}
	// 				}else{
	// 					$data->status = false;
	// 					$data->message = "Votre login/email et/ou le mot de passe est incorrect !";
	// 				}
	// 			}else{
	// 				$data->status = false;
	// 				$data->message = "Une erreur s'est produite lors de la connexion, Veuillez recommencer !";
	// 			}
	// 		}
	// 	}else{
	// 		$data->status = false;
	// 		$data->message = "Veuillez renseigner integralement vos parametres de connexion !";
	// 	}
	// 	return $data;
	// }

	public static function authentification(string $login, string $password){
		$data = new RESPONSE;
		if ($password != "" && $login != "") {
			$datas = static::findBy(["login = "=> $login, "password = "=>hasher($password)]);
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
					$data->message = "L'accès à cette application vous a été restrient !";
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


	public function reset(){
		$this->is_new = 1;
		$this->login = substr(uniqid(), 6);
		$pass = substr(uniqid(), 5);
		$this->password = hasher($pass);
		$this->historique("Reinitialisation des parametres de connexion de $this->name $this->lastname");
		$data = $this->save();
		if ($data->status) {
			ob_start();
			include(__DIR__."/../../sections/home/elements/mails/reset.php");
			$contenu = ob_get_contents();
			ob_end_clean();
			EMAIL::send([$this->email], "Reinitialisation de vos parametres de connexion", $contenu);
			$data->setUrl("home", "access", "index");
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


	public function get_login(){
		return $this->login;
	}

	public function set_login($login){
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



	public function emailIsValide($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$datas = static::findBy(["email = "=>$email]);
			if (count($datas) == 0) {
				$this->email = $email;
				return true;
			}else{
				$gestionnaireTemp = $datas[0];
				if ($gestionnaireTemp->id === $this->id) {
					$this->email = $email;
					return true;
				}else{
					$this->email = null;
					return false;
				}
			}
		}else{
			return false;
		}
	}


	public function verifier_password($pass){
		if ($this->password === hasher($pass)) {
			return true;
		}else{
			return false;
		}
	}

	public function set_password($password){
		$this->password = hasher($password);
		return $this;
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}
?>