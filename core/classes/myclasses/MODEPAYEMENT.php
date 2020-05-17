<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class MODEPAYEMENT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $initial;
	public $etat_id = ETAT::ENCOURS;

	const ESPECE = 1;
	const PRELEVEMENT_ACOMPTE = 2;
	const CHEQUE = 3;
	const VIREMENT_BANQUAIRE = 4;
	const MOBILE_MONEY = 5;

	public function enregistre(){}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}
?>