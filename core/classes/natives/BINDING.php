<?php 
namespace Native;
use Home\TABLE;
use \stdClass;


class BINDING
{

	public static $BOUTON_RAPIDE;
	public static $LI_NAV;
	public static $CARD_DASHBOARD;
	public static $FORM_COMMANDER;
	public static $TAB_CLIENT_LABEL;
	public static $TAB_CLIENT_BODY;
	public static $FORM_AFFICHER_COMMANDE;



	public static function binding($modul, $dossier, $element, $mode = true){
		$module = MODULE::findBy(["name = "=>$modul]);
		if (count($module) > 0) {
			$module = $module[0];
			$data = $module->module_conforme();
			if ($data->status) {
				$rooter = new ROOTER;
				$rooter->set_module($modul);
				$data = $rooter->verifier_acces();
				if (($data->status == false && $data->id == 10) OR $data->status) {
					$path = __DIR__."/../../modules/module_$modul/elements/$dossier/$element.php";
					if ($mode == true) {
						affichage($path);
					}else{
						return realpath($path);
					}
				}else{
					return FILES::FILE_NULL();
				}
			}
		}
	}


	public static function html($type, $object, $element = null, $name=""){
		$types = explode("-", $type);
		if (in_array("select", $types)) { 
			if (!in_array("tableau", $types)  && $name == ""){ $name = $object."_id"; } ?>
			<select class="select2 " <?= (in_array("multiple", $types))?"multiple=multiple":"" ?> name="<?= $name ?>" style="width: 100%;">
			<!-- 			<select data-placeholder="Choisissez ..." class="chosen-select" <?= (in_array("multiple", $types))?"multiple=multiple":"" ?> name="<?= $name ?>" style="width: 100%;">
				-->				<?php 
				$column = $name;
				if (!isset($element) || is_null($element) || !is_object($element)) {
								//on declare un onjet au hasard
					$element = new stdClass;
					$element->$column = null;
				}

				if (!in_array("tableau", $types)){
					$object = TABLE::fullyClassName($object);
					$datas = $object::getAll();
				}else{
					$datas = $object;
				}
				if (in_array("startnull", $types)) { ?>
					<option value="0"> -- Aucun --</option>
				<?php }
				foreach ($datas as $key => $item) { 
					if(isset($item->abbreviation)){$item->name .= " :: ".$item->abbreviation; }
					if(isset($item->sigle)){$item->name .= " :: ".$item->sigle; }
					?>
					<option value="<?= $item->getId() ?>" <?= ($item->getId() == $element->$column)?"selected":"" ?>><?= $item->name() ?></option>
				<?php } ?>
			</select>

		<?php  }else if($type == "checkbox" || $type == "radio"){
			$class = TABLE::fullyClassName($object);
			$datas = $class::getAll();
			foreach ($datas as $key => $item) { ?>
				<label class="cursor"><input type="<?= $type ?>" value="<?= $item->getId() ?>" <?= (is_array($element) && in_array($item->getId(), $element))?"checked=checked":""  ?> name="<?= ($name != "")?$name:$object."_id" ?>"> <?= $item->name ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
			<?php } 
		}
	}


}