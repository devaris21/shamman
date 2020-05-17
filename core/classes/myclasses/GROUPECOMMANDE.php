<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class GROUPECOMMANDE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $client_id;
	public $etat_id = ETAT::ENCOURS;
	

	public function enregistre(){
		return $data = $this->save();
	}


	public static function etat(){
		foreach (static::findBy(["etat_id ="=>ETAT::ENCOURS]) as $key => $groupe) {
			$test = false;
			foreach (PRODUIT::getAll() as $key => $produit) {
				if ($groupe->reste($produit->getId()) > 0) {
					$test = true;
					break;
				}
			}
			if (!$test) {
				$groupe->etat_id = ETAT::VALIDEE;
				$groupe->save();
			}
		}
	} 


	public function reste(int $produit_id){
		$total = 0;

		$requette = "SELECT SUM(quantite) as quantite FROM lignecommande, produit, commande, groupecommande WHERE lignecommande.produit_id = produit.id AND lignecommande.commande_id = commande.id AND commande.groupecommande_id = groupecommande.id AND groupecommande.id = ? AND commande.etat_id != ? AND produit.id = ? GROUP BY produit.id";
		$item = LIGNECOMMANDE::execute($requette, [$this->getId(), ETAT::ANNULEE, $produit_id]);
		if (count($item) < 1) {$item = [new LIGNECOMMANDE()]; }
		$total += $item[0]->quantite;

		$requette = "SELECT SUM(quantite_livree) as quantite FROM lignelivraison, produit, livraison, groupecommande WHERE lignelivraison.produit_id = produit.id AND lignelivraison.livraison_id = livraison.id AND livraison.groupecommande_id = groupecommande.id AND groupecommande.id = ? AND livraison.etat_id != ? AND produit.id = ? GROUP BY produit.id";
		$item = LIGNELIVRAISON::execute($requette, [$this->getId(), ETAT::ANNULEE, $produit_id]);
		if (count($item) < 1) {$item = [new LIGNELIVRAISON()]; }
		$total -= $item[0]->quantite;
		return $total;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>