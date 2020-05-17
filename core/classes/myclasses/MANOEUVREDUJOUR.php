<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class MANOEUVREDUJOUR extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $productionjour_id;
	public $manoeuvre_id;
	public $price;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUCTIONJOUR::findBy(["id ="=>$this->productionjour_id]);
		if (count($datas) == 1) {
			$datas = MANOEUVRE::findBy(["id ="=>$this->manoeuvre_id]);
			if (count($datas) == 1) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}




	public function sentenseCreate(){
	
	}


	public function sentenseUpdate(){
	}


	public function sentenseDelete(){
	}

}



?>