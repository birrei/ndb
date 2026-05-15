<?php 

include_once("dbconn/class.db.php"); 
include_once("class.htmlinfo.php"); 
include_once("class.htmlselect.php"); 
include_once("class.htmltable.php"); 
include_once("class.kalender.php"); 

class Kalendertag {

  // aktuell nicht verwendet  

  // private $db; 
  private $info; 

  public int $ID; 
  public string $Datum; 
  public string $Name;   // aktuell = Datum, ggf. erweiterte Bezeichnung möglich  

  public function __construct(){
    $conn=new DBConnection(); 
    $this->db=$conn->db; 
    $this->info=new HTML_Info(); 
  }
   





    // neue ID zurückgeben 

  






}  



 



?>