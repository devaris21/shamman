<?php 
namespace Home;

$title = "BRIXS | Toutes les livraisons par tricycle en cours";

$livraisons = LIVRAISON::findBy(["vehicule_id ="=>VEHICULE::TRICYCLE, "etat_id ="=>ETAT::VALIDEE, "reste > "=>0]);
$total = count($livraisons);

?>