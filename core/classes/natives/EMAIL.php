<?php
namespace Native;

use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Plugins_DecoratorPlugin;
use \registerPlugin;
/**
 * 
 */
class EMAIL 
{


	public static function send(Array $destinateurs, String $subject, $lemessage, $format = false){
		if (@fsockopen("www.google.com", 80)) {
			// Create the Transport
			$transport = (new Swift_SmtpTransport(SHAMMAN::getConfig("mail", "transport"), SHAMMAN::getConfig("mail", "transport")))
			->setUsername(SHAMMAN::getConfig("mail", "email"))
			->setPassword(SHAMMAN::getConfig("mail", "password"))
			->setEncryption(SHAMMAN::getConfig("mail", "encryption"));
			$mailer = new Swift_Mailer($transport);

			//create the message 
			$message = (new Swift_Message())
			->setFrom([SHAMMAN::getConfig("mail", "email") => SHAMMAN::getConfig("metadata", "organization")])
			->setSubject($subject)
			->setBody($lemessage,'text/html');

			if ($format) {
				$decorator = new Swift_Plugins_DecoratorPlugin($destinateurs);
				$mailer->registerPlugin($decorator);
				foreach ($destinateurs as $key => $value) {
					$message->addTo($key);
				}
			}else{
				$message->setTo($destinateurs);
			}

			$result = $mailer->send($message);
		}else{
			mail("21shamman06@gmail.com", $subject, $lemessage);
		}
	}


}

?>