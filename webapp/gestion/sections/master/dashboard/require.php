<?php 
namespace Home;

GROUPECOMMANDE::etat();
LIVRAISON::ResetProgramme();

$title = "BRIXS | Tableau de bord";

$tableau = [];
foreach (PRODUIT::getAll() as $key => $prod) {
	$data = new \stdclass();
	$data->name = $prod->name();
	$data->livrable = $prod->livrable();
	$data->attente = $prod->enAttente();
	$data->commande = $prod->commandee();
	$tableau[] = $data;
}

foreach (OPERATION::enAttente() as $key => $item) {
	$item->actualise();
	if ($item->categorieoperation->typeoperationcaisse->getId() == TYPEOPERATIONCAISSE::SORTIE) {
		$item->etat_id == ETAT::VALIDEE;
		$item->save();
	}
}

foreach (APPROVISIONNEMENT::findBy(["etat_id ="=>ETAT::VALIDEE]) as $key => $item) {
	if ($item->getId() != 1) {
		$item->datelivraison == dateAjoute(-1);
		$item->save();
	}
}

?>