<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "abonnement") {
	$code = "";
	for ($i=1; $i < 6; $i++) { 
		$name = "bloc".$i;
		if (isset($_POST[$name]) && $_POST[$name] != "" && strlen($_POST[$name]) == 5) {
			$code .= $_POST[$name];
		}else{
			break;
		}
	}
	if (strlen($code) == 25) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://www.example.com/tester.phtml");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"code=$code");

// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

// Further processing ...
		//if ($server_output == "OK") { ... } else { ... }

	}else{
		$data->status = false;
		$data->message = "Veuillez correctement renseigner tous les 5 blocs qui composent le code de validation";
	}
	echo json_encode($data);
}

