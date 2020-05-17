<?php 
namespace Home;

$title = "BRIXS | Toutes les livraisons en cours";

$livraisons = LIVRAISON::findBy(["etat_id !="=>ETAT::PARTIEL]);
$total = 0;
foreach ($livraisons as $key => $liv) {
	if ($liv->etat_id == ETAT::ENCOURS) {
		$total++;
	}
}

?>