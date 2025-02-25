<?php 

class SchuelerMaterial {

  public $table_name; 

  public $ID='';
  public $MaterialID='';
  public $SchuelerID=''; 
    // DatumVon XXX 
  // DatumBis XXX 
  public $Bemerkung=''; 

  public $titles_selected_list; 
  public $Title='Material Schüler';
  public $Titles='Material Schüler'; 
  public $Parent='Material'; // "Material" (dem Material wird ein Schüler hinzugefügt) 
                             // oder "Schueler" (dem Schueler wird Material hinzugefügt) 

  public function __construct(){
    $this->table_name='schueler_material'; 
  }

  
  function insert_row ($SchuelerID, $MaterialID) {

    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($SchuelerID=='' || $MaterialID=='') {
      return false; 
    }
       
    $insert = $db->prepare("INSERT INTO `schueler_material` 
                            SET SchuelerID=:SchuelerID, 
                                MaterialID = :MaterialID");

    $insert->bindParam(':SchuelerID', $SchuelerID);
    $insert->bindParam(':MaterialID', $MaterialID);

    try {
      $insert->execute(); 
      $this->ID=$db->lastInsertId();
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($insert, $e);  ; 
    }
  }  
 
  function load_row() {
    include_once("dbconn/cl_db.php");   
    $conn = new DbConn(); 
    $db=$conn->db; 

    $select = $db->prepare("SELECT ID
                          , MaterialID
                          , SchuelerID
                          , COALESCE(Bemerkung, '') as Bemerkung
                          FROM `schueler_material`
                          WHERE `ID` = :ID");

    $select->bindParam(':ID', $this->ID, PDO::PARAM_INT);
    $select->execute(); 

    if ($select->rowCount()==1) {
      $row_data=$select->fetch();
      $this->MaterialID=$row_data["MaterialID"]; 
      $this->SchuelerID=$row_data["SchuelerID"];     
      $this->Bemerkung=$row_data["Bemerkung"];
      return true; 
    } 
    else {
      return false; 
    }  
  }  

  function delete(){
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
    // echo '<p>Lösche schueler_material ID: '.$this->ID.':</p>';
    $delete = $db->prepare("DELETE FROM `schueler_material` WHERE ID=:ID"); 
    $delete->bindValue(':ID', $this->ID);  

    try {
      $delete->execute(); 
      // echo '<p>Zeile wurde gelöscht.</p>';   
      return true;        
    }
    catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($delete, $e);  
      return false; 
    }  
  }  

}

 



?>