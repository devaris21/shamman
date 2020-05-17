<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = COMMANDE::findBy(["id ="=> $this->getId(), 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$commande = $datas[0];
		$commande->actualise();

		$commande->fourni("lignecommande");

		$title = "BRIXS | Bon de commande ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>