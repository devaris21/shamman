<?php 
namespace Native;
/**
 * 
 */
class SHAMMAN
{


	//verification de tous les fichiers systemes
	public static function getConfig($type = "", $name = ""){
		if ($type != "") {
			include(__DIR__."/../../../configuration");
			if (isset($configs[strtolower($type)])) {
				if ($name != "") {
					if (isset($configs[strtolower($type)][strtolower($name)])) {
						return $configs[strtolower($type)][strtolower($name)];
					}else{
						return $configs[strtolower($type)];
					}
				}else{
					return $configs;
				}
			}else{
				return null;
			}
		}else{
			return $configs;
		}
	}


	
	public static function error(String $message){
		?>
		<script type="text/javascript">
			alert("dmnnj")
			toastr.info('Hi! I am info message.');
		</script>
		<?php
	}

	//////////////////////////////////////////
	/////// DATE & TIMESTAMPS ////////////////
	



	//////////////////////////////////////////
	/////// DATE & TIMESTAMPS ////////////////
	public static function now(){
		return date("Y-m-d H:i:s");
	}



	public static function count(Array $tableau, $propriete, $type = "somme"){
		$total = 0;
		if ($type == "somme") {
			foreach ($tableau as $key => $obj) {
				$total += intval($obj->$propriete);
			}
		}else if($type == "avg"){
			foreach ($tableau as $key => $obj) {
				$total += intval($obj->$propriete);
			}
			$total = $total / count($tableau);
		}
		return $total;
	}






	//convertir chiffre en lettre
	function chiffreEnLettre($a){ 
		$joakim = explode('.',$a); 
		if (isset($joakim[1]) && $joakim[1]!=''){ 
			return enLettre($joakim[0]).' virgule '.enLettre($joakim[1]) ; 
		} 
		if ($a<0) return 'moins '.enLettre(-$a); 
		if ($a<17){ 
			switch ($a){ 
				case 0: return 'zero'; 
				case 1: return 'un'; 
				case 2: return 'deux'; 
				case 3: return 'trois'; 
				case 4: return 'quatre'; 
				case 5: return 'cinq'; 
				case 6: return 'six'; 
				case 7: return 'sept'; 
				case 8: return 'huit'; 
				case 9: return 'neuf'; 
				case 10: return 'dix'; 
				case 11: return 'onze'; 
				case 12: return 'douze'; 
				case 13: return 'treize'; 
				case 14: return 'quatorze'; 
				case 15: return 'quinze'; 
				case 16: return 'seize'; 
			} 
		} else if ($a<20){ 
			return 'dix-'.enLettre($a-10); 
		} else if ($a<100){
			if ($a%10==0){
				switch ($a){
					case 20: return 'vingt';
					case 30: return 'trente';
					case 40: return 'quarante';
					case 50: return 'cinquante';
					case 60: return 'soixante';
					case 70: return 'soixante-dix';
					case 80: return 'quatre-vingt';
					case 90: return 'quatre-vingt-dix';
				}
			} else if ($a<70){
				return enLettre($a-$a%10).'-'.enLettre($a%10);
			} else if ($a<80){
				return enLettre(60).'-'.enLettre($a%20);
			} else{
				return enLettre(80).'-'.enLettre($a%20);
			}
		} else if ($a==100){
			return 'cent';
		} else if ($a<200){
			return enLettre(100).($a%100!=0?' '.enLettre($a%100):'');
		} else if ($a<1000){
			return enLettre((int)($a/100)).' '.enLettre(100).' '.($a%100!=0?enLettre($a%100):'');
		} else if ($a==1000){
			return 'mille';
		} else if ($a<2000){
			return enLettre(1000).($a%1000!=0?' '.enLettre($a%1000):'');
		} else if ($a<1000000){
			return (enLettre((int)($a/1000)).' '.enLettre(1000).' '.($a%1000!=0?enLettre($a%1000):''));
		}  else if ($a<2000000){
			return (enLettre((int)($a/1000000)).' million '.($a%1000000!=0?' '.enLettre($a%1000000):''));
		}  
		else if ($a<1000000000){
			return (enLettre((int)($a/1000000)).' millions '.($a%1000000!=0?' '.enLettre($a%1000000):''));
		}  else if ($a<2000000000){
			return (enLettre((int)($a/1000000000)).' milliard '.($a%1000000000!=0?' '.enLettre($a%1000000000):''));
		}  
	}  



}
?>