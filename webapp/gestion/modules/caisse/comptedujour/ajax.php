<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	$data->setUrl("gestion", "caisse", "comptedujour", "$date");
	echo json_encode($data);
}