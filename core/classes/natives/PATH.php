<?php 
namespace Native;
use Home\TABLE;
use \stdClass;


class PATH
{

	public function relativePath($filepath){
		return $path = "../../webapp/$this->section/modules/$this->module/$this->page/$filepath";
	}

	public function rootPath($filepath){
		return $path = "../../$filepath";
	}

	public function assets($file){
		return "../../webapp/$this->section/assets/$file";
	}

	public function elements($file){
		return "../../webapp/$this->section/elements/$file";
	}

	public function stockage($type, $dossier, $file){
		return "../../../stockage/$type/$dossier/$file";
	}


}