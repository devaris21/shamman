<?php 
namespace Native;
use \PDO ;
//require "";
/**
 * 
 */
class DATABASE
{



	public static function CONNEXION(){
		$driver = SHAMMAN::getConfig("database", "driver");
		$charset = SHAMMAN::getConfig("database", "charset");
		$host = SHAMMAN::getConfig("database", "host");
		$port = SHAMMAN::getConfig("database", "port");
		$dbname = SHAMMAN::getConfig("database", "dbname");
		$login = SHAMMAN::getConfig("database", "login");
		$password = SHAMMAN::getConfig("database", "password");
		try{
			$bdd = new PDO("$driver:host=$host; port=$port; charset=$charset; dbname=$dbname", $login, $password, [PDO::ATTR_PERSISTENT => true]);
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $bdd;
		}catch(EXCEPTION $e){
			SHAMMAN::error($e->getMessage());
		}
		return null;
	}





	public function getAllDatabases(){
		$this->myconnexion();
		$resultats = $this->bdd->query("SHOW TABLES");
		while ($ligne = $resultats->fetch()) {
			$tableau[] = $ligne["Tables_in_v4"];
		}
		return $tableau;
	}


	public function getAllTables(){
		$this->myconnexion();
		$resultats = $this->bdd->query("SHOW TABLES");
		while ($ligne = $resultats->fetch()) {
			$tableau[] = $ligne["Tables_in_v4"];
		}
		return $tableau;
	}


	public function genererStructure(){
		$contenu = "\n\n";
		$contenu .= "-------------   Hotella inc Tous droits reservés \n";
		$contenu .= "-------------------------------------------------------------------------------------------------\n";
		$contenu .= "-------------   GENERATION DU LA STRUCTURE DE LA BASE DE DONNEES le ".datelong(date("Y-m-d H:i:s"))."\n";
		$contenu .= "-------------------------------------------------------------------------------------------------\n\n\n\n\n";
		foreach ($this->getAllTables() as $key => $value) {
			$debut = "------- STRUCTURE DE LA TABLE '$value' -------\n---------------------------------------------------\n";
			$delete = "DROP TABLE IF EXISTS `$value`;\n";
			$script = $this->bdd->query("SHOW CREATE TABLE $value");
			$script = $debut."".$delete."".($script->fetch())[1].";\n\n\n\n";
			$contenu .= $script;
		}
		return $contenu;
	}


	public function genererData(){
		$total = "\n\n";
		$total .= "-------------   Hotella inc Tous droits reservés \n";
		$total .= "-------------------------------------------------------------------------------------------------\n";
		$total .= "-------------   GENERATION DES DONNEES DE LA BASE DE DONNEES le ".datelong(date("Y-m-d H:i:s"))."\n";
		$total .= "-------------------------------------------------------------------------------------------------\n\n\n\n\n";
		foreach ($this->getAllTables() as $key => $value) {
			$enregistrements = "";
			$debut = "------- DONNEES DE LA TABLE '$value' -------\n---------------------------------------------------\n";
			$items = $records = $this->bdd->query("SELECT * FROM $value");
			$nb_rows = $records->rowCount();
			$nb_columns = $records->columnCount();
			$i = 0;
			while ($ligne = $items->fetch()) {
				$enregistrement ="\n(";
				for ($j=0; $j < $nb_columns; $j++) {
					if ($j == $nb_columns-1) {
						$enregistrement .='"'.$ligne[$j].'"' ;
					}else{
						$enregistrement .='"'.$ligne[$j].'", ' ;
					}
				}	
				$i++;
				if ($i == $nb_rows) {
					$enregistrements .= $enregistrement.") ";	
				}else{
					$enregistrements .= $enregistrement."), ";	
				}
			}
			$requette = "------ Il n'y a pas de données !";
			if ($enregistrements != "") {
				$requette = "INSERT INTO $value VALUES $enregistrements ;";
			}
			$total .= $debut."".$requette."\n\n\n";
		}		
		return $total;
	}



	public function generation($structure = true, $data = true){
		//$folder = "../../../../synchronisation/".date("Y-m-d")."/";
		$folder = FILES::FILE_SYNCHRONISATION()."/".date("Y-m-d_H_i_s")."/";
		$structure = $folder."structure.sql";
		$data = $folder."data.sql";
		if(!file_exists($folder)){ mkdir($folder, 0777, true); }
		if ($structure) {
			$res = file_put_contents($folder."structure.sql", $this->genererStructure());
		}
		if ($data) {
			$res = file_put_contents($folder."data.sql", $this->genererData());
		}
	}



}


?>