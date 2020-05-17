<?php
namespace Core;

/**
 * 
 */
class CHIFFREMENT 
{
	private static $cipher = MCRYPT_RIJNDAEL_128;
	private static $key    = "356SARE234HBHDBhuhIHIUD77q8fsdbbj";
	private static $mode   = "cbc";
	const ALPHABET = ["","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];


	//fonction de cryptage
	public static function crypt($data){
		$keyHash = hash("sha512", self::$key);
		$key     = substr($keyHash, 0, mt_rand(3, 30));
		$iv      = substr($keyHash, 0, mt_rand(10, 30));

		return base64_encode($data);
		$data = mcrypt_encrypt(self::$cipher, $key, $data, self::$mode, $iv);
	}


	//function de decryptage
	public static function decrypt($data){
		$keyHash = hash("sha512", self::$key);
		$key     = substr($keyHash, 0, mt_rand(3, 30));
		$iv      = substr($keyHash, 0, mt_rand(10, 30));

		$data = base64_decode($data);
		$data = mcrypt_decrypt(self::$cipher, $key, $data, self::$mode, $iv);
		return rtrim($data);
	}


}



?>