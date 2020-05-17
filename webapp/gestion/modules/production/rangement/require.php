<?php 
namespace Home;

$title = "BRIXS | Rangements de la production";

$productions = PRODUCTIONJOUR::findBy(["etat_id !="=>ETAT::ENCOURS]);


?>