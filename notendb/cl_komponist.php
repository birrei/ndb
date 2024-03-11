<?php 
 
class Komponist {

  public $table_name; 

  
  // public $UserErrorInfo; 
  // public $ErrorInfo; 
  // public $UserInfo; 

  public function __construct(){
    $this->table_name='komponist'; 
  }

  /* Auswahl-Element Komponisten */ 
  function print_select($value_selected=''){
    
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT DISTINCT 
            `ID` as KomponistID, CONCAT(`Nachname`, ', ', `Vorname`) as Name 
            FROM `komponist` 
            order by `Nachname`"; 

  	$conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("KomponistID", $value_selected, true); 
      
    }
    catch (PDOException $e) {
      echo '<p>Ein Fehler ist aufgetreten.</p>';
      // XXX fehlerklasse einbinden 
      echo '<p>'.$e->getMessage().'</p>';
      // echo '<p>'.$stmt->debugDumpParams(); 
    }
  }


}

 



?>