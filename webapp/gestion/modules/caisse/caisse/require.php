<?php 
namespace Home;
$operations = OPERATION::findBy(["DATE(created) >= "=> dateAjoute(-7)]);
$entrees = $depenses = [];
foreach ($operations as $key => $value) {
	$value->actualise();
	if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
		$entrees[] = $value;
	}else{
		$depenses[] = $value;
	}
}
$statistiques = OPERATION::statistiques();

$title = "BRIXS | Compte de caisse";
?>