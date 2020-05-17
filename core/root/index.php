<?php 

use Native\ROOTER;
require_once __DIR__."/includes.php";

if (count(Home\MYCOMPTE::getAll()) == 0) {
	require_once __DIR__."/firstdatabase.php";
}

$rooter = new ROOTER;

$rooter->render();


?>