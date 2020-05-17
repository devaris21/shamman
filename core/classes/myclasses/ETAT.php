<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ETAT extends TABLE
{

		public static $tableName = __CLASS__;
		public static $namespace = __NAMESPACE__;

		const ANNULEE = 1;
		const ENCOURS = 2;
		const PARTIEL = 3;
		const VALIDEE = 4;

		public $name;
		public $class;

		public function enregistre(){}


		public function sentenseCreate(){}
		public function sentenseUpdate(){}
		public function sentenseDelete(){}

	}
	?>