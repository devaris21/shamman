<?php 
namespace Home;

unset_session("ressources");

if ($this->getId() != null) {
	$datas = FOURNISSEUR::findBy(["id ="=> $this->getId()]);
	if (count($datas) > 0) {
		$fournisseur = $datas[0];
		$fournisseur->actualise();

		$approvisionnements = $fournisseur->fourni("approvisionnement", ["etat_id ="=>ETAT::ENCOURS]);

		$fournisseur->fourni("approvisionnement");



		$fluxcaisse = $fournisseur->fourni("operation");
		usort($fluxcaisse, "comparerDateCreated2");

		$title = "BRIXS | ".$fournisseur->name();

		session("fournisseur_id", $fournisseur->getId());
		
	}else{
		header("Location: ../master/fournisseurs");
	}
}else{
	header("Location: ../master/fournisseurs");
}
?>