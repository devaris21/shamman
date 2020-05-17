<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNELIVRAISON extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $livraison_id;
	public $produit_id;
	public $quantite;

	public $reste = 0;
	public $quantite_livree;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = LIVRAISON::findBy(["id ="=>$this->livraison_id]);
		if (count($datas) == 1) {
			$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
			if (count($datas) == 1) {
				if ($this->quantite > 0) {
					$this->quantite_livree = $this->quantite;
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "La quantité n'est pas correcte !";
				}
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


	public function sentenseUpdate(){}


	public function sentenseDelete(){}

}



?>