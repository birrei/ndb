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

  function insert_row ($ParentID) {
    // ParentID ist SchuelerID oder MaterialID 
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db; 
       
    // echo 'Insert: MaterialID: '.$this->MaterialID; // test 

    switch($this->Parent) {
      case 'Material':
        $insert = $db->prepare("INSERT INTO `schueler_material` 
                            SET MaterialID = :ParentID"       
       );
      break; 
      case 'Schueler':
        $insert = $db->prepare("INSERT INTO `schueler_material` 
                            SET SchuelerID = :ParentID"       
       );
      break; 
    }

    $insert->bindParam(':ParentID', $ParentID);

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
   
  function update_row ($SchuelerID, $MaterialID, $Bemerkung) {
    include_once("dbconn/cl_db.php");
    $conn = new DbConn(); 
    $db=$conn->db;  
    
    // echo 'Update: MaterialID: '.$MaterialID.', SchuelerID: '.$SchuelerID.', Bemerkung: '.$Bemerkung; // test 

    $update = $db->prepare("UPDATE `schueler_material` 
              SET 
                MaterialID= :MaterialID
              , SchuelerID=:SchuelerID         
              , Bemerkung = :Bemerkung
              WHERE ID=:ID
              "           
           );

    $update->bindParam(':ID', $this->ID);
    $update->bindParam(':MaterialID', $MaterialID);
    $update->bindParam(':SchuelerID', $SchuelerID);
    $update->bindParam(':Bemerkung', $Bemerkung);

    try {
      $update->execute(); 
      $this->load_row();   
    }
      catch (PDOException $e) {
      include_once("cl_html_info.php"); 
      $info = new HtmlInfo();      
      $info->print_user_error(); 
      $info->print_error($update, $e);  ; 
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