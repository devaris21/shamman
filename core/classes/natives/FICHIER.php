<?php 
namespace Native;
use Home\TABLE;
/**
 * 
 */
class FICHIER extends TABLE // juste pour la fonction hydrater()
{
	

	public static $tableName = __CLASS__;
	public $name ;
	public $tmp_name;
	public $size ;
	public $type ;

	private static $MAX_SIZE = 2*1024*1024; //taille du fichier en megaoctets
	private static $EXTENSIONS_IMAGE = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
	private static $EXTENSIONS_PDF = ["application/pdf"];



	private function size(){
		if ($this->size <= static::$MAX_SIZE) {
			return true;
		}else{
			return false;
		}
	}


	public function is_image(){
		if (in_array($this->type, static::$EXTENSIONS_IMAGE)) {
			return true;
		}else{
			return false;
		}
	}


	public function is_pdf(){
		if (in_array($this->type, static::$EXTENSIONS_PDF)) {
			return true;
		}else{
			return false;
		}
	}


	public function upload($type, $dossier, $filename){
		$data = new RESPONSE;
		$final_path = realpath(__DIR__."/../../../stockage/$type/$dossier/");
		if ($this->tmp_name != "") {
			if ($this->name != "") {
				if ($this->size()) {
					//nouveau nom du fichier
					$extension=strtolower(substr(strrchr($this->name, '.'), 1));
					$this->name = $filename.".".$extension;

					//uploading
					$final_path = $final_path."/".$this->name;
					$resultat = move_uploaded_file($this->tmp_name, $final_path);
					if ($resultat){
						$data->status = true;
						$data->filename = $this->name;
					}
				}else{
					$data->status = false;
					$data->message = "La taille du fichier est trop grande !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez donner un nom au fichier !";
			}
		}else{
			$data->status = false;
			$data->message = "Aucune image selectionnée !";
		}
		return $data;
	}


	public function enregistre(){}

	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}
?>
