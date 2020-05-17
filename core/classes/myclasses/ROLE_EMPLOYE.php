<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class ROLE_EMPLOYE extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $role_id;
	public $employe_id;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = ROLE::findBy(["id ="=>$this->role_id]);
		if (count($datas) == 1) {
			$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
			if (count($datas) == 1) {
				$datas = static::findBy(["employe_id ="=>$this->employe_id, "role_id ="=>$this->role_id,]);
			if (count($datas) == 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Vous avez déjà un accès à cette fonctionnalité !";
			}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors du prix !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors du prix !";
		}
		return $data;
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>