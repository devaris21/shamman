<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class CONSOMMATIONJOUR extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $ladate;
	public $comment = "";
	public $groupepersonnel_id = 0;
	public $employe_id = 0;
	


	public function enregistre(){
		$data = new RESPONSE;
		$this->ladate = dateAjoute();
		return $this->save();
	}



	public static function today(){
		$datas = static::findBy(["ladate ="=>dateAjoute()]);
		if (count($datas) > 0) {
			return $datas[0];
		}else{
			$ti = new PRODUCTIONJOUR();
			$data = $ti->enregistre();
			if ($data->status) {
				foreach (PRODUIT::getAll() as $key => $produit) {
					$ligne = new LIGNEPRODUCTIONJOUR();
					$ligne->productionjour_id = $data->lastid;
					$ligne->produit_id = $produit->getId();
					$ligne->enregistre();
				}
			}
			return $ti;
		}
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>