<?php 
 
class Sammlung {

  public $table_name; 

  
  // public $UserErrorInfo; 
  // public $ErrorInfo; 
  // public $UserInfo; 

  public function __construct(){
    $this->table_name='sammlung'; 
  }

  function print_select($value_selected=''){
   /* Auswahl-Element Sammlung (beschränkt auf benannte ID, da echte Auswahl nicht benötigt) */    
    include_once("cl_db.php");  
    include_once("cl_html_select.php");

    $query="SELECT DISTINCT 
            `ID` as SammlungID, Name 
            FROM `sammlung` 
            WHERE ID=:ID
            order by `Name`"; 

  	$conn = new DbConn(); 
    $db=$conn->db; 
  
    $stmt = $db->prepare($query); 
    $stmt->bindParam(':ID', $value_selected, PDO::PARAM_INT);

    try {
      $stmt->execute(); 
      $html = new HtmlSelect($stmt); 
      $html->print_select("SammlungID", $value_selected, false); 
      
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