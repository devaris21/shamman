<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class OPTION_ZONELIVRAISON extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $name;
	public $zonelivraison_id;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$datas = ZONELIVRAISON::findBy(["id ="=>$this->zonelivraison_id]);
			if (count($datas) == 1) {
				if ($this->price >= 0) {
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "Le prix renseigné est incorrect !";
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