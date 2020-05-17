<?php 
namespace Home;

if ($this->getId() != "") {
	$date = $this->getId();
}else{
	$date = dateAjoute();
}

$commandes = COMMANDE::findBy(["DATE(created) = " => $date, "etat_id !="=>ETAT::ANNULEE]);
$livraisons = LIVRAISON::findBy(["DATE(created) = " => $date, "etat_id > "=>ETAT::ANNULEE, "etat_id !="=>ETAT::PARTIEL]);
$approvisionnements = APPROVISIONNEMENT::findBy(["visibility ="=>1, "DATE(created) = " => $date, "etat_id !="=>ETAT::ANNULEE]);

$operations = OPERATION::findBy(["DATE(created) = " => $date]);
$entrees = $depenses = [];
foreach ($operations as $key => $value) {
	$value->actualise();
	if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
		$entrees[] = $value;
	}else{
		$depenses[] = $value;
	}
}


$datas = PRODUCTIONJOUR::findBy(["ladate = " => $date]);
if (count($datas) == 1) {
	$productionjour = $datas[0];
	$productionjour->actualise();
}


$employes = [];
$connexions = CONNEXION::listeConnecterDuJour($date);
foreach ($connexions as $key => $value) {
	$datas = EMPLOYE::findBy(["id ="=>$value->employe_id]);
	if (count($datas) == 1) {
		$employes[] = $datas[0];
	}
}


$demandes = DEMANDEENTRETIEN::jour($date);
$pannes = PANNE::jour($date);

$entretiensv = ENTRETIENVEHICULE::jour($date);
$entretiensm = ENTRETIENMACHINE::jour($date);


$title = "BRIXS | Rapport général de la journée ";
?>