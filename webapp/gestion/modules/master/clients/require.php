<?php 
namespace Home;

$title = "BRIXS | Tous les clients !";
$clients = CLIENT::findBy(["visibility ="=>1],[],["name"=>"ASC"]);

?>