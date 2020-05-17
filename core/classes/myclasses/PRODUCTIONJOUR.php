<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PRODUCTIONJOUR extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $ladate;
	public $comment = "";
	public $groupemanoeuvre_id = 0;
	public $groupemanoeuvre_id_rangement = 0;
	public $employe_id = 0;
	public $etat_id = ETAT::ENCOURS;
	public $dateRangement ;

	public $total_rangement = 0;
	public $total_production = 0 ;
	public $total_livraison = 0 ;
	


	public function enregistre(){
		$data = new RESPONSE;
		$this->ladate = dateAjoute();
		return $this->save();
	}



	public static function today(){
		$datas = static::findBy(["ladate ="=>dateAjoute()]);
		if (count($datas) > 0) {
			$pro = $datas[0];

			if (count($pro->fourni("ligneproductionjour")) == 0) {
				foreach (PRODUIT::getAll() as $key => $produit) {
					$ligne = new LIGNEPRODUCTIONJOUR();
					$ligne->productionjour_id = $pro->getId();
					$ligne->produit_id = $produit->getId();
					$ligne->enregistre();
				}
			}

			if (count($pro->fourni("ligneconsommationjour")) == 0) {
				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$ligne = new LIGNECONSOMMATIONJOUR();
					$ligne->productionjour_id = $pro->getId();
					$ligne->ressource_id = $ressource->getId();
					$ligne->enregistre();
				}
			}

			return $pro;
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

				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$ligne = new LIGNECONSOMMATIONJOUR();
					$ligne->productionjour_id = $data->lastid;
					$ligne->ressource_id = $ressource->getId();
					$ligne->enregistre();
				}
			}
			return $ti;
		}
	}



	public static function ranges(){
		return static::findBy(["etat_id ="=>ETAT::VALIDEE]);
	}

	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>