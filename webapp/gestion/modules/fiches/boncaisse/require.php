<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = OPERATION::findBy(["id ="=> $this->getId(), 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$operation = $datas[0];
		$operation->actualise();

		$title = "BRIXS | Bon de caisse ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>