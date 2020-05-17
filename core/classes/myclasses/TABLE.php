<?php 
namespace Home;
use Native\DATABASE;
use Native\RESPONSE;
use \PDO;

/**
 * 
 */
abstract class TABLE 
{

    protected static $namespaces = ["Native", "Home"];


    public $id         = null;
    public $created    = null;
    public $modified   = null;
    public $protected  = NON;
    public $deleted     = OUI;
    public $visibility = 1;

    public $_lastId;
    public $_sentense;



    abstract public function enregistre();

    


    public function hydrater(Array $table1){
        if(isset($table1["id"]) && !empty($table1["id"])){
            $this->setId($table1["id"]);
            $this->actualise();
        }
        $table2 = $this->getProperties();
        $table = array_intersect_key($table1, $table2);
        foreach ($table as $key => $value) {
            if ($key !== "id") {
                $this->$key = $value;
            }
        }
    }





    public function uploading(Array $files){}
    
    public function getProperties(){
        return get_object_vars($this);
    }


    public function json_encode(){
        return json_encode($this);
    }


    public function isProtected(){
        if ($this->getProtected() == 1) {
            return true;
        }else{
            return false;
        }
    }



    public function name(){
        if (isset($this->lastname)) {
            return $this->name." ".$this->lastname;
        }else{
            return $this->name;
        }
    }


    public static function encours(){
        return static::findBy(["etat_id ="=>ETAT::ENCOURS]);
    }



    public function getProtected(){
        return $this->protected;
    }

    public function setProtected(int $protected){
        $this->protected = $protected;
        return $this;
    }


    public function setCreated($date = null){
        $this->created = $date;
        if ($date == null) {
            $this->created = date("Y-m-d H:i:s");
        }
        return $this;
    }


    public function setModified($date = null){
        $this->modified = $date;
        if ($date == null) {
            $this->modified = date("Y-m-d H:i:s");
        }
        return $this;
    }


    public function historique(String $texte){
        $this->sentense = $texte;
    }


    //initialiser la connexion et recuperer le nom de la table
    public static function tableName(){
        $bdd = DATABASE::CONNEXION();
        $temp = explode("\\", strtolower(static::$tableName)) ;
        $table = end($temp);
        return ["bdd"=>$bdd, "table"=>$table, "namespace"=>static::$namespace, "tableClass"=>static::$tableName];
    }


    //obtenir le nom complet d'une table, avec son namespace
    public static function fullyClassName(String $classe){
        $test = false;
        foreach (TABLE::$namespaces as $key => $module) {
            $myclass = ucfirst($module)."\\".strtoupper($classe);
            if (class_exists($myclass)) {
                $test = true;
                break;
            }            
        }
        if ($test) {
            return $myclass;
        }else{
            return $classe;
        }
    }


    //cloner un objet
    public function cloner($item){
        $objs = get_object_vars($item);
        foreach ($objs as $key => $value) {
            $this->$key = $value;
        }
    }



    //executer manuellement une requette sur une table
    public static function execute(String $requette, Array $params = []){
        extract(static::tableName());
        $req = $bdd->prepare($requette);
        $req->execute($params);
        return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
    }


    //requette simple et sans retour particulier
    public static function query($requette, $params = []){
        $bdd = DATABASE::CONNEXION();
        $req = $bdd->prepare($requette);
        $req->execute($params);
    }


    //ajouter ou mettre a jour un record dans une table
    public function save(){
        $data = new RESPONSE;
        extract(static::tableName());
        //liste des champs de la table
        $req = $bdd->query("SHOW columns FROM $table ");
        $arrayB = $req->fetchAll(PDO::FETCH_COLUMN, "field");
        foreach ($arrayB as $key => $value) {
            $tab[$value] = null;
        }
        //liste des proprietes de la classe
        $table2 = $this->getProperties();
        $table1 = array_intersect_key($table2, $tab);
        //on genere les params de la requette
        $setter = ""; $i = 0;
        unset($table1["id"]);
        foreach ($table1 as $key => $value) {
            $i++;
            if (count($table1) == $i) {
                $setter .= "$key= :$key ";
            }else{
                $setter .= "$key= :$key, ";
            }
        }

        if ($this->getId() != "") {
            $data->mode ="update";
            //c'est une mise a jour (update)
            $id = $this->getId();
            if ($this->modified == null) {
                $this->setModified();
            }
            $requette = "UPDATE $table SET $setter WHERE id = $id";
        }else{
            $data->mode ="insert";
            //c'est un ajout (insert)
            if ($this->created == null) {
              $this->setCreated();
          }
          if ($this->modified == null) {
            $this->setModified();
        }

        $requette = "INSERT INTO $table SET $setter";
    }
        //liste des proprietes de la classe
    $table2 = $this->getProperties();
    $table1 = array_intersect_key($table2, $tab);
    unset($table1["id"]);

    $req = $bdd->prepare($requette);
    foreach ($table1 as $key => $value) {
        if (!is_array($value)) {
            $req->bindValue(":$key", $value);
        }else{
            $req->bindValue(":$key", "");
        }
    }
    $resultat = $req->execute();

    if ($resultat) {
        $data->status = true;
        $data->message = "Données enregistrées avec succes !";
        if ($data->mode == "insert") {
            $class = self::fullyClassName($table);
            $temp = $class::findLastId();
            $id = $temp->getId();
            $data->lastid = $id;
            $this->setId($id);
        }else{
            $data->lastid = $this->getId();
        }

        if ($this::$tableName != self::fullyClassName("history") ) {
            $class = self::fullyClassName($table);
            $element = new $class();
            $element->cloner($this);
            HISTORY::createHistory($element, $data->mode);
        }
    }else{
        $data->status = false;
        $data->message = "Une erreur s'est produite lors du save()";
    }
    return $data;
}




//recuperer tous les enregistrements d'une table
public static function getAll(){
    extract(static::tableName());
    $req = $bdd->query("SELECT * FROM $table WHERE deleted = 0 ");
    return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
}


//les fonctions "findBy" et "findLike" spour rechercher a partir de n'importe quelle colonne
public static function findBy(Array $params=[], Array $group =[], Array $order = [], int $limit=0, $conn="AND"){
    extract(static::tableName());
        //les conditions
    $where = $groupe = $orders =""; $i =0;
    foreach ($params as $key => $value) {
        $i++;
        $where .= "$conn $key :$i ";
    }
        //les group
    if (count($group) > 0) {
        $groupe ="GROUP BY ";
        if (count($group) > 0) {
            $groupe .= implode(", ", $group);
        }
    }
        //les orders
    if (count($order) > 0) {
        $i =0;
        $orders ="ORDER BY ";
        foreach ($order as $key => $value) {
            $i++;
            if (count($order) == $i) {
                $orders .= "$key $value ";
            }else{
                $orders .= "$key $value, ";
            }
        }
    }

        //
    $lim ="";
    if ($limit > 0) {
        $lim ="LIMIT $limit";
    }

    $requette = "SELECT * FROM $table WHERE deleted = 0 $where $groupe $orders $lim";
    $req = $bdd->prepare($requette);
    $i =0;
    foreach ($params as $key => $value) {
        $i++;
        $req->bindValue(":$i", $value);
    }
    $req->execute();
    return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");         
}



//recuperer le dernier enregistrement d'une table
public static function findLastId(){
    extract(static::tableName());
    $req = $bdd->query("SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT 1");
    $datas = $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
    if (count($datas) > 0) {
        return $datas[0];
    }else{
        return false;
    }
}



//fourni toutes les informations d'un objet et ses affiliations
public function actualise(){
    if (is_numeric($this->getId())) {
        $datas = static::findBy(["id = "=> $this->getId()]);
        if (count($datas) > 0) {
            $temp = $datas[0];
            $objs = get_object_vars($temp);
            foreach ($objs as $key => $value) {
                if (strstr($key, "_id") != false) {
                    $coupes = explode("_id",$key);
                    $class = $coupes[0];
                    $mot = self::fullyClassName($class);
                    $datas = $mot::findBy(["id = "=>$value]);
                    if (isset($coupes[1])) {
                        $class.=$coupes[1];
                    }
                    if (count($datas) == 1) {
                        $temp->$class = $datas[0];
                        $temp->$class->actualise();
                    }else{
                        $temp->$class = new $mot();
                    }
                }
            }
            $objs = get_object_vars($temp);
            foreach ($objs as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}


// recuperer tous les enregistrements d'une table fille
public function fourni($nomTable, $params = [], Array $group =[], Array $order = [], int $limit=0, $conn="AND"){
    extract(static::tableName());
    $this->actualise();
    $name = strtolower($nomTable)."s";
    $table .="_id";
    $class =  self::fullyClassName($nomTable);
    $array = array_merge(["$table = "=> $this->getId()], $params);
    $datas = $class::findBy($array, $group, $order, $limit, $conn);
    $this->$name = $this->items = $datas;
    return $datas;
}


//Suppression logique d'un enregistrement dans la base de données
public function supprime(){
    $data = new RESPONSE;
    extract(static::tableName());
    $this->actualise();
    if ($this->protected == 0) {
        $req = $bdd->prepare("UPDATE $table SET deleted = 1 WHERE id=?");
        $req->execute([$this->getId()]);
        $data->status = true;
        $data->message = "La suppression a été effectuée avec succès ! ";
        HISTORY::createHistory($this, "delete");
    }else{
        $data->status = false;
        $data->message = "Vous ne pouvez pas supprimer cet élément. Il est protégé !";
    }
    return $data;
}



//Supprimer physique et definitive d'un enregistrement dans la base de données
public function delete(){
    $data = new RESPONSE;
    extract(static::tableName());
    $this->actualise();
    if ($this->protected == 0) {
        $req = $bdd->prepare("DELETE FROM $table WHERE id=?");
        $req->execute([$this->getId()]);
        $data->status = true;
        $data->message = "La suppression a été effectuée avec succès ! ";
        HISTORY::createHistory($this, "delete");
    }else{
        $data->status = false;
        $data->message = "Vous ne pouvez pas supprimer cet élément. Il est protégé !";
    }
    return $data;
}

}
?>