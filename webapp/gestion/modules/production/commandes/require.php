<?php 
namespace Home;

$title = "BRIXS | Toutes les commandes en cours";

GROUPECOMMANDE::etat();
$groupes = GROUPECOMMANDE::encours();

?>