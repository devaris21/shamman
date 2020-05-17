<?php 
namespace Home;

$title = "BRIXS | Tous les fournisseurs";

$fournisseurs = FOURNISSEUR::findBy(["visibility ="=>1]);


?>