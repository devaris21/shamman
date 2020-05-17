<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ETATCOMMANDE extends TABLE
{

	/* -1 = annuler;
		0= reserver
		1= encours
		2= terminer / (fini mais pas retirer ou pas regleé pour les commandes)
		3= fini (seulement pour les commandes)
		*/

		public static $tableName = __CLASS__;
		public static $namespace = __NAMESPACE__;

		public $name;
		public $class;

		public function enregistre(){}


			public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

	}
	?>