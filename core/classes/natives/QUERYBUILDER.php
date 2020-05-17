<?php 
namespace Home;
use Native\DATABASE;
use Native\RESPONSE;
use \PDO;

/**
 * 
 */
abstract class QUERYBUILDER 
{


    public $query = "";
    public $sentense = "";


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //initialiser la connexion et recuperer le nom de la table
    public static function tableName(){
        $bdd = DATABASE::CONNEXION();
        $temp = explode("\\", strtolower(static::$tableName)) ;
        $table = end($temp);
        return ["bdd"=>$bdd, "table"=>$table, "namespace"=>static::$namespace, "tableClass"=>static::$tableName];
    }



    //executer manuellement une requette sur un static
    public static function execute(String $requette, Array $params){
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
            $id = $this->getId();
            $this->set_modified() ;
            $requette = "UPDATE $table SET $setter WHERE id=$id";
        }else{
            $data->mode ="insert";
            $this->set_created();
            $this->set_modified();
            $requette = "INSERT INTO $table SET $setter";
        }
        //liste des proprietes de la classe
        $table2 = $this->getProperties();
        $table1 = array_intersect_key($table2, $tab);
        unset($table1["id"]);

        $req = $bdd->prepare($requette);
        foreach ($table1 as $key => $value) {
            $req->bindValue(":$key", $value);
        }
        $test = $req->execute();

        if ($test) {
            $data->status = true;
            $data->message = "succes dans le save()";
            if ($data->mode == "insert") {
                //recuperer le lastid
                $class = self::fullyClassName($table);
                $temp = $class::findLastId();
                $id = $temp->getId();
                $data->lastid = $id;
                $this->setId($id);
            }else{
                $data->lastid = $this->getId();
            }

            if ($this::$tableName != self::fullyClassName("historique") ) {
                //L'historque
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



    //Supprimer partiel d'un record
    public function supprime(){
        $data = new RESPONSE;
        extract(static::tableName());
        $this->actualise();
        //on verifie si on peut vraiment le supprimé
        if (intval($this->id) > 0 && $this->protected == 0) {
            $req = $bdd->prepare("UPDATE $table SET valide=0 WHERE id=?");
            $req->execute([$this->getId()]);
            $data->status = true;
            $data->message = "La suppression a été effectuée avec succès ! ";
            //L'historque
            HISTORY::createHistory($this, "delete");
        }else{
            $data->id = 2;
            $data->status = false;
            $data->message = "Vous ne pouvez pas supprimer cet élément. Il est protégé !";
        }
        return $data;
    }



        //Supprimer definitive d'un record
    public function delete(){
        $data = new RESPONSE;
        extract(static::tableName());
        $this->actualise();
        //on verifie si on peut vraiment le supprimé
        if (intval($this->id) > 0 && $this->protected == 0) {
            $req = $bdd->prepare("DELETE FROM $table WHERE id=?");
            $req->execute([$this->getId()]);
            $data->status = true;
            $data->message = "La suppression a été effectuée avec succès ! ";
            //L'historque
            HISTORY::createHistory($this, "delete");
        }else{
            $data->id = 2;
            $data->status = false;
            $data->message = "Vous ne pouvez pas supprimer cet élément. Il est protégé !";
        }
        return $data;
    }



    //recuperer tous les records d'une table
    public static function getAll($class = null){
        extract(static::tableName());
        $req = $bdd->query("SELECT * FROM $table WHERE valide = 1 ");
        if ($class != null) {
            $req = $bdd->query("SELECT * FROM $class WHERE valide = 1 ");
            $tableName = TABLE::fullyClassName($class);
        }
        return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
    }


    //recuperer le dernier record
    public static function findLast($champ="id", $nb=1, $order="ASC"){
        extract(static::tableName());
        $req = $bdd->query("SELECT * FROM $table WHERE valide = 1 ORDER BY $champ $order LIMIT $nb");
        return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
    }


    //recuperer le dernier record
    public static function findLastId(){
        extract(static::tableName());
        $req = $bdd->query("SELECT * FROM $table WHERE valide = 1 ORDER BY id DESC LIMIT 1");
        $datas = $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");
        if (count($datas) > 0) {
            return $datas[0];
        }else{
            return false;
        }
    }




    //les fonctions "findBy" et "findLike" spour rechercher a partir de n'importe quelle colonne
    public static function findLike(String $search, Array $proprietes=["name"], int $limit=0){
        extract(static::tableName());
        //les conditions
        $where = ""; $i = 1;
        $j = count($proprietes);
        foreach ($proprietes as $key => $value) {
            if ($i == $j) {
                $where .= "$value LIKE '%$search%'";
            }else{
                $where .= "$value LIKE '%$search%' OR ";
            }
            $i++;
        }
        
        //limite
        $lim ="";
        if ($limit > 0) {
            $lim ="LIMIT $limit";
        }

        $requette = "SELECT * FROM $table WHERE valide = 1 AND $where $lim";
        $req = $bdd->prepare($requette);
        $req->execute();
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

        $requette = "SELECT * FROM $table WHERE valide = 1 $where $groupe $orders $lim";
        $req = $bdd->prepare($requette);
        $i =0;
        foreach ($params as $key => $value) {
            $i++;
            $req->bindValue(":$i", $value);
        }
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, "$tableClass");         
    }




    public function cloner($item){
        $objs = get_object_vars($item);
        foreach ($objs as $key => $value) {
            $this->$key = $value;
        }
    }


}
?>