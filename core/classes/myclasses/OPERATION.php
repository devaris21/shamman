<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class OPERATION extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $montant;
	public $categorieoperation_id;
	public $modepayement_id;
	public $employe_id;
	public $etat_id = ETAT::VALIDEE;
	public $comment;
	public $client_id = CLIENT::CLIENTSYSTEME;
	public $manoeuvre_id;
	public $fournisseur_id;
	public $structure;
	public $numero;
	public $date_approbation;
	public $isModified = 0;

	public $acompteClient = 0;
	public $detteClient = 0;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
		if (count($datas) == 1) {
			$datas = CATEGORIEOPERATION::findBy(["id ="=>$this->categorieoperation_id]);
			if (count($datas) == 1) {
				$cat = $datas[0];
				if ( $cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE || ($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE && $this->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE)) {

					if ( $cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE || ($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE && static::resultat(PARAMS::DATE_DEFAULT, dateAjoute1()) >= $this->montant) || ($this->categorieoperation_id == CATEGORIEOPERATION::APPROVISIONNEMENT) ) {

						$this->reference = "BCA/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
						if (($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) && !in_array($this->modepayement_id, [MODEPAYEMENT::ESPECE, MODEPAYEMENT::PRELEVEMENT_ACOMPTE]) ) {
							$this->etat_id = ETAT::ENCOURS;
						}else{
							$this->etat_id = ETAT::VALIDEE;
						}
						
						if (intval($this->montant) > 0) {
							$data = $this->save();
						}else{
							$data->status = false;
							$data->message = "Le montant pour cette opération est incorrecte, verifiez-le !";
						}
					}else{
						$data->status = false;
						$data->message = "Vous ne pouvez pas effectuer cette opération, le solde du compte est insuffisant !";
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement pour effectuer cette opération !!";
				}				
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
		}
		return $data;
	}



	public function valider(){
		$data = new RESPONSE;
		$this->etat_id = ETAT::VALIDEE;
		$this->date_approbation = date("Y-m-d H:i:s");
		$this->historique("Approbation de l'opération de caisse N° $this->reference");
		return $this->save();
	}



	public static function entree(string $date1 = "2020-04-01", string $date2){
		$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ?";
		$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::ENTREE, $date1, $date2]);
		if (count($item) < 1) {$item = [new OPERATION()]; }
		return $item[0]->montant;
	}



	public static function sortie(string $date1 = "2020-04-01", string $date2){
		$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ? ";
		$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::SORTIE, $date1, $date2]);
		if (count($item) < 1) {$item = [new OPERATION()]; }
		return $item[0]->montant;
	}


	public static function resultat(string $date1 = "2020-04-01", string $date2){
		return static::entree($date1, $date2) - static::sortie($date1, $date2);
	}




	public static function versements(string $date1 = "2020-04-01", string $date2){
		$requette = "SELECT SUM(montant) as montant  FROM operation WHERE operation.categorieoperation_id = ? AND operation.valide = 1 AND operation.client_id = ? AND DATE(operation.created) >= ? AND DATE(operation.created) <= ? ";
		$item = OPERATION::execute($requette, [CATEGORIEOPERATION::PAYEMENT, CLIENT::CLIENTSYSTEME, $date1, $date2]);
		if (count($item) < 1) {$item = [new OPERATION()]; }
		return $item[0]->montant;
	}




	public static function enAttente(){
		return static::findBy(["etat_id ="=> ETAT::ENCOURS]);
	}



	public static function statistiques(){
		$tableau_mois = ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
		$tableau_mois_abbr = ["", "Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"];
		$mois1 = date("m", strtotime("-1 year")); $year1 = date("Y", strtotime("-1 year"));
		$mois2 = date("m"); $year2 = date("Y");
		$tableaux = [];
		while ( $year2 >= $year1) {
			$debut = $year1."-".$mois1."-01";
			$fin = $year1."-".$mois1."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);
			$data = new RESPONSE;
			$data->name = $tableau_mois_abbr[intval($mois1)]." ".$year1;
			//$data->name = $year1."-".start0($mois1)."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);;
			////////////

			$data->entree = OPERATION::entree($debut, $fin);
			$data->sortie = OPERATION::sortie($debut, $fin);
			$data->resultat = OPERATION::resultat($debut, $fin);

			$tableaux[] = $data;
			///////////////////////
			if ($mois2 == $mois1 && $year2 == $year1) {
				break;
			}else{
				if ($mois1 == 12) {
					$mois1 = 01;
					$year1++;
				}else{
					$mois1++;
				}
			}
		}
		return $tableaux;
	}



	public static function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		while ( $index <= $date2 ) {
			$debut = $index;
			$fin = dateAjoute1($index, 1);

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->sortie = OPERATION::sortie($debut, $fin);
			$data->entree = OPERATION::entree($debut, $fin);
			$data->resultat = OPERATION::resultat($debut, $fin);

			$tableaux[] = $data;
			///////////////////////
			
			$index = $fin;
		}
		return $tableaux;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>