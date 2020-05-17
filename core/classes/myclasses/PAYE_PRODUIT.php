<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PAYE_PRODUIT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $produit_id;
	public $price = 0;
	public $price_rangement = 0;
	public $price_livraison = 0;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
		if (count($datas) == 1) {
			if ($this->price >= 0 && $this->price_rangement >= 0 && $this->price_livraison >= 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Le prix renseigné est incorrect !";
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