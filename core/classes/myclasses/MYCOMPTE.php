<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class MYCOMPTE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $identifiant;
	public $expired;
	

	public function enregistre(){
		return $this->save();
	}


	public function sentenseCreate(){
		return $this->sentense = "Nouvelle Installation, premier démarrage";
	}


	public function sentenseUpdate(){
	}


	public function sentenseDelete(){
	}

}
?>