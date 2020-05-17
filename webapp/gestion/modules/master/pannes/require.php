<?php 
namespace Home;

$pannes = PANNE::getAll();
foreach ($pannes as $key => $value) {
	$value->actualise();
	$value->type = "machine";
}

$demandes = DEMANDEENTRETIEN::getAll();
foreach ($demandes as $key => $value) {
	$value->actualise();
	$value->type = "vehicule";
}
$lespannes = array_merge($pannes, $demandes);
usort($lespannes, "comparerDateCreated");




$pannes = ENTRETIENMACHINE::getAll();
foreach ($pannes as $key => $value) {
	$value->actualise();
	$value->type = "machine";
}

$demandes = ENTRETIENVEHICULE::getAll();
foreach ($demandes as $key => $value) {
	$value->actualise();
	$value->type = "vehicule";
}
$lesentretiens = array_merge($pannes, $demandes);
usort($lesentretiens, "comparerDateCreated");

$title = "BRIXS | Pannes  de véhicules/Machine";
?>