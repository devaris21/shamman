<?php 
namespace Native;
/**
 * 
 */
class RESPONSE
{

  private $priority = 0;
  public $status = true;
  public $id;
  public $message;
  public $url = null;


  /**
   * Class Constructor
   * @param    $code   
   * @param    $reponse   
   * @param    $message   
   */
  public function __construct($status=null, $id=null, $message=null)
  {
    $this->status = $status;
    $this->id = $id;
    $this->message = $message;
  }



  public function setUrl($section, $module, $page="", $id=""){
    //cette est redefinie dans rooter
    return $this->url = "/$section/$module/$page|$id";
  }

  public function setUrl0($url){
    //cette est redefinie dans rooter
    $this->url = $url;
  }

  /**
   * @return mixed
   */
  public function getPriority()
  {
    return $this->priority;
  }

  /**
   * @param mixed $priority
   *
   * @return self
   */
  public function setPriority($priority)
  {
    $this->priority = $priority;

    return $this;
  }
}
?>