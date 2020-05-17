<?php 
namespace Home;

unset_session("ressources");

$title = "BRIXS | Toutes les livraisons en cours";

$approvisionnements = APPROVISIONNEMENT::findBy(["visibility ="=> 1]);
$total = 0;
foreach ($approvisionnements as $key => $liv) {
	if ($liv->etat_id == ETAT::ENCOURS) {
		$total++;
	}
}

?>