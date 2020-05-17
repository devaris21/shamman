<?php
namespace Home;

$params = PARAMS::findLastId();
$mycompte = MYCOMPTE::findLastId();

if ($mycompte->expired < dateAjoute()) {
	$title = "Renouvellement de l'abonnement";
}else{
	header("Location: ../../gestion/access/login");
}



?>