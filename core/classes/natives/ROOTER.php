<?php 
namespace Native;
use Native\SHAMMAN;
use Home\PARAMS;
/**
 * 
 */
class ROOTER extends PATH
{

    private $url;
    private $language = "fr";
    public $section = "devaris21";
    public $module = "start";
    public $page = "select";
    public $id ;


    private $token;


    const SECTION_SIMPLE = ["devaris21"];
    const SECTION_ADMIN = ["gestion"];
    const SECTION_STOCKAGE = ["images", "documents"];


    public function __construct(){
        if (isset($_GET["query"])) {
            $this->url = $_GET["query"];
        }
        $this->createRoot();
    }



    private function createRoot(){
        if ($this->url != "") {
            $tab = explode("/", strtolower($this->url));
            $this->section = $tab[0];
            if (in_array($this->section, static::SECTION_ADMIN)) {
                $this->module = "access";
                $this->page = "login";
            }
            if (isset($tab[1]) && $tab[1] != "") {
                $this->module = $tab[1];
            }

            if (isset($tab[2]) && $tab[2] != "") {
                $tab = explode("|", strtolower($tab[2]));
                $this->page = $tab[0];
                if (isset($tab[1])) {
                    $this->id = $_GET["id"] = $tab[1];
                }
            }
        }
    }




    public function render(){
        $data = new RESPONSE;
        $data->status = true;
        $this->is_admin = in_array($this->section, static::SECTION_ADMIN) ;
        if ($this->is_admin && $this->module != "access") {
            $data = PARAMS::checkTimeout($this->section);
            if ($data->status == true) {
                $params = PARAMS::findLastId();
                $mycompte = MYCOMPTE::findLastId();


                if ($mycompte->expired >= dateAjoute()) {
                       //pour les etats recaps
                    $datea = dateAjoute(-30);
                    $dateb = dateAjoute(1);

                    $productionjour = PRODUCTIONJOUR::today();
                    $productionjour->actualise();
                    session("lastUrl", $this->url);

                    if ($this->section == "gestion") {
                        $datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
                        if (count($datas) >0) {
                            $employe = $datas[0];
                            if ($employe->is_allowed()) {
                                $tableauDeRoles = [];
                                foreach ($employe->fourni("role_employe") as $key => $value) {
                                    $tableauDeRoles[] = $value->role_id;
                                };
                                if (!in_array($this->module, ROLE::MODULEEXCEPT)) {
                                    $datas = ROLE::findBy(["name ="=>$this->module]);
                                    if (count($datas) == 1) {
                                        $role = $datas[0];
                                        if (in_array($role->getId(), $tableauDeRoles)) {
                                            $employe->actualise();

                                        }else{
                                            $this->new_root("devaris21", "home", "erreur500");
                                            $this->render();
                                            return false;
                                        }
                                    }else{
                                        $this->new_root("devaris21", "home", "erreur500");
                                        $this->render();
                                        return false;
                                    }
                                }
                            }else{
                                $this->new_root("devaris21", "home", "erreur500");
                                $this->render();
                                return false;
                            }
                        }else{
                            $this->new_root($this->section, "access", "login");
                            $this->render();
                            return false;
                        }
                    }
                }else{
                    $this->new_root("devaris21", "home", "expired");
                    $this->render();
                    return false; 
                }
            }else{
                $this->new_root($this->section, "access", "login");
                $this->render();
                return false;
            }
        }


        $path = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/index.php";
        $require = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/require.php";

        if (file_exists($path)) {
            $path = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/index.php";
            $require = __DIR__."/../../../webapp/$this->section/modules/$this->module/$this->page/require.php";

            require realpath($require);
            require realpath($path);

            $token = hasher(bin2hex(random_bytes(32)));
            session("token", $token);
            session("verif_token", $token);

        }else{
            $path = __DIR__."/../../../webapp/devaris21/modules/home/erreur404/index.php";
            $require = __DIR__."/../../../webapp/devaris21/modules/home/erreur404/require.php";
            require realpath($require);
            require realpath($path);
        }
    }




    //redefinir la route
    private function new_root($section, $module, $page="", $id=""){
        $this->section = $section;
        $this->module = $module;
        $this->page   = $page;
        $this->id     = $id;
    }




    public function url($section, $module, $page="", $id=""){
        return $this->url = "../../$section/$module/$page|$id";
    }

    public function setUrl(String $url){
        $this->url = $url;
        return $this;
    }

    public function getUrl(){
        return $this->url;
    }


    public function set_module($module)
    {
        $this->module = $module;
        return $this;
    }

    public function getModule(){
        return $this->module;
    }

    public function getPage(){
        return $this->page;
    }

    public function getId()
    {
        return $this->id;
    }



}
?>