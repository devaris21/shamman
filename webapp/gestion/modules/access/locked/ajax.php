<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "locked") {
	if ($password != "") {
		$datas = EMPLOYE::findBy(["id ="=> getSession("employe_connecte_id")]);
		if (count($datas) == 1) {
			$user = $datas[0];
			if ($user->checkPassword($password)) {
				session("employe_connecte_id", $user->getId());
				$data->status = true;
				session("last_access", time());
				unset_session("page_session");
				$data->url = "/".getSession("lastUrl");
			}else{
				$data->status = false;
				$data->message = "Le mot de passe est incorrect !";
			}	
		}else{
			$data->status = false;
			$data->setUrl("employe", "access", "login");
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez renseigner votre mot de passe ";
	}
	echo json_encode($data);
}