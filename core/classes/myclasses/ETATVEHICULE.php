<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ETATVEHICULE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const RAS = 1;
	const MISSION = 2;
	const PANNE = 3;
	const ENTRETIEN = 4;
	const INDISPONIBLE = 5;


	public $name;
	public $class;

	public function enregistre(){}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}
?>