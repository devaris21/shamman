<?php
namespace Core;
require_once "../../vendor/autoload.php";

class SMS_ORANGE {
	public $basic;
	public $sender;
	/*public $applicationID;
	public $clientID;
	public $secret;*/

	public $token_type;
	public $access_token;
	public $expires_in;


	public function __construct($basic, $sender){
	if ($basic=="" || $sender=="" /*|| $applicationID=="" || $clientID=="" || $secret==""*/) {
		echo("Veuillez renseigner tous les parametres de connexion !");
	}else{
		$this->basic = $basic;
		$this->sender = $sender;
			/*$this->applicationID = $applicationID;
			$this->clientID = $clientID;
			$this->secret = $secret;*/

			$this->token_type = "";
			$this->access_token = "";
			$this->expires_in = "";

			echo("La classe a été bien créée ! <br>");
		}
	}


	public function connexion( ){
		$curl = curl_init();
		$params = [
			'grant_type' => 'client_credentials',
		];
		$params_string = http_build_query($params);
		$headers = array("Authorization: $this->basic");
		$opts = [
			CURLOPT_POST 		   => true,
			CURLOPT_URL            => "https://api.orange.com/oauth/v2/token",
			CURLOPT_POSTFIELDS 	   => $params_string,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_CONNECTTIMEOUT => 30
		];
		curl_setopt_array($curl, $opts);
		$response = json_decode(curl_exec($curl));
		$this->token_type = $response->token_type;
		$this->access_token = $response->access_token;
		$this->expires_in = $response->expires_in;

		echo("Connexion reussie <br>");
		curl_close($curl);
	}

	private function rewrite_numero($numero){
		$numero = str_replace(" ", "", $numero);
		return  "255".$numero;
	}


	public function envoi_sms($numero, $message){
		$numero = rewrite_numero($numero);
		$curl = curl_init();
		$params = [
			'outboundSMSMessageRequest' => 
			[
				"address"                => "tel:+$numero",
				"senderAddress"          => "tel:+$this->sender",
				"outboundSMSTextMessage" => ["message" => $message]
			]
		];
		$params_string = json_encode($params);
		$headers = array("Authorization: Bearer $this->access_token", "Content-Type:application/json");
		$opts = [
			CURLOPT_POST 		   => true,
			CURLOPT_URL            => "https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B$this->sender/requests",
			CURLOPT_POSTFIELDS 	   => $params_string,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_CONNECTTIMEOUT => 30
		];
		curl_setopt_array($curl, $opts);
		$res = curl_exec($curl);
		$ressource = $res->outboundSMSMessageRequest->resourceURL;
		if (isset($ressource) && !empty($ressource)) {
			$tab = explode('/', $ressource);
			echo "Message envoyé avec succes ! id = ".$tab[8];
		}else{
			echo "Erreur lors de l'envoi du message";
		}
		curl_close($curl);
	}





	public function compte_sms(){
		$curl = curl_init();
		$headers = array("Authorization: Bearer $this->access_token");
		$opts = [
			CURLOPT_URL            => "https://api.orange.com/sms/admin/v1/contracts",
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_CONNECTTIMEOUT => 30
		];
		curl_setopt_array($curl, $opts);
		$response = json_decode(curl_exec($curl));
		$nb = ($response->partnerContracts->contracts[0]->serviceContracts[0]->availableUnits);
		echo "Il vous reste $nb messages dans votre compte !";
		curl_close($curl);
	}






	public function historique_achat(){
		$curl = curl_init();
		$headers = array("Authorization: Bearer $this->access_token");
		$opts = [
			CURLOPT_POST 		   => false,
			CURLOPT_URL            => "https://api.orange.com/sms/admin/v1/purchaseorders",
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_CONNECTTIMEOUT => 30
		];
		curl_setopt_array($curl, $opts);
		$response = json_decode(curl_exec($curl));
		var_dump($response);
		curl_close($curl);
	}
}





$sms = new SMS_ORANGE("Basic U1ZqZW1qVmo2Y08weW9pUUlvTnRHRkRjVUFxUVBBOTA6U0FRTUdqNTBBbWd4MFRXVw==", "22507046010");
// $sms->connexion();

// $message= "Quickly Livraison & Expédition.\n";
// $message.= "Votre commande a été enregistré avec succes!\n";
// $message.="Bon de commande:15 et N°Quickly:25658965\n";
// $message.="Quickly vous remercie !";
// $sms->envoi_sms("22502285967", $message);
// $sms->compte_sms();
//$sms->historique_achat();


?>
