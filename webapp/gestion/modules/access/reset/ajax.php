<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "resetPassword") {
	$datas = GESTIONNAIRE::findBy(["email ="=>$email]);
	if (count($datas) > 0) {
		$element = $datas[0];
		$data = $element->resetPassword();
	}else{
		$data->status = false;
		$data->message = "Désolé, vous n'etes pas enregistré sur la plateforme !";
	}	
	echo json_encode($data);
}

