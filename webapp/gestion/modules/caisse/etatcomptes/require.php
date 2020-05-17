<?php 
namespace Home;

if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = PARAMS::DATE_DEFAULT;
	$date2 = dateAjoute(1);
}

$entree = OPERATION::entree($date1 , $date2);
$sortie = OPERATION::sortie($date1 , $date2);

$resultat = OPERATION::resultat($date1 , $date2);

$datas = CATEGORIEOPERATION::getAll();
$datas1 = $datas2 = [];
foreach ($datas as $key => $item) {
	$item->actualise();
	$item->montant = comptage($item->fourni("operation", ["DATE(created) >= " => $date1, "DATE(created) <= " => $date2]), "montant", "somme");
	if ($item->montant > 0) {
		if ($item->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE  && $item->montant > 0) {
			$item->pct = round((($item->montant / $entree ) * 100), 2);
			$datas1[] = $item;
		}elseif ($item->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE  && $item->montant > 0){
			$item->pct = round((($item->montant / $sortie ) * 100), 2);
			$datas2[] = $item;
		}
	}else{
		unset($datas[$key]);
	}
}



usort($datas1, "comparerPct_");
usort($datas2, "comparerPct_");



$stats = OPERATION::stats($date1, $date2);

$title = "BRIXS | Etat récapitulatif des clients ";
?>